<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class LargePatientsImport extends DefaultValueBinder implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsEmptyRows,
    WithCustomValueBinder,
    WithChunkReading,
    WithBatchInserts,
    WithMapping
{
    use SkipsErrors;

    protected $rowCount = 0;
    protected $skippedRows = 0;
    protected $batch = [];
    protected $batchSize = 500;
    protected $existingNames = [];
    protected $existingMrns = [];
    protected $existingIdNumbers = [];

    public function __construct()
    {
        // Pre-load existing patient names to avoid repeated database queries
        $this->existingNames = Patient::pluck('Name')->map(function($name) {
            return strtolower(trim($name));
        })->toArray();
        // Pre-load existing MRNs and ID numbers to avoid repeated database queries
        $this->existingMrns = Patient::pluck('MRN')->toArray();
        $this->existingIdNumbers = Patient::pluck('Nationality_ID')->toArray();
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_null($value)) {
            $cell->setValueExplicit('', DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function map($row): array
    {
        $mappedRow = [];
        foreach ($row as $key => $value) {
            $mappedRow[strtolower(trim($key))] = $value;
        }
        return $mappedRow;
    }

    public function model(array $row)
    {
        try {
            // Skip if required fields are empty
            if (empty($row['name']) || empty($row['mrn'])) {
                $this->skippedRows++;
                return null;
            }

            // Check if patient with this MRN or Nationality_ID already exists
            if (in_array($row['mrn'], $this->existingMrns)) {
                Log::info('Skipping patient with existing MRN:', ['mrn' => $row['mrn']]);
                $this->skippedRows++;
                return null;
            }

            // If nationality_id is provided, check if it already exists
            if (!empty($row['nationality_id']) && in_array($row['nationality_id'], $this->existingIdNumbers)) {
                Log::info('Skipping patient with existing Nationality ID:', ['nationality_id' => $row['nationality_id']]);
                $this->skippedRows++;
                return null;
            }

            // Convert nationality_id to string and handle empty values
            $nationalityId = '0'; // Default value for empty nationality_id
            if (isset($row['nationality_id']) && !empty($row['nationality_id'])) {
                $nationalityId = (string) $row['nationality_id'];
                if (strpos($nationalityId, 'E') !== false) {
                    $nationalityId = number_format((float)$nationalityId, 0, '', '');
                }
            }

            $this->rowCount++;

            // Log every 1000th record to track progress
            if ($this->rowCount % 1000 === 0) {
                Log::info("Processing record {$this->rowCount} of import");
                // Force garbage collection every 1000 records
                if (function_exists('gc_collect_cycles')) {
                    gc_collect_cycles();
                }
            }

            // Add to batch
            $this->batch[] = [
                'Name' => $row['name'],
                'MRN' => $row['mrn'],
                'Nationality_ID' => $nationalityId,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // If batch is full, insert it
            if (count($this->batch) >= $this->batchSize) {
                $this->insertBatch();
            }

            return null; // We're handling the insert manually
        } catch (\Exception $e) {
            Log::error('Error processing row:', [
                'row' => $row,
                'error' => $e->getMessage(),
                'row_number' => $this->rowCount
            ]);
            $this->skippedRows++;
            return null;
        }
    }

    protected function insertBatch()
    {
        if (empty($this->batch)) {
            return;
        }

        try {
            // Use chunking for large batches
            foreach (array_chunk($this->batch, 100) as $chunk) {
                try {
                    DB::table('patients')->insert($chunk);
                    // Add newly inserted names to our tracking array
                    foreach ($chunk as $record) {
                        $this->existingNames[] = strtolower(trim($record['Name']));
                    }
                } catch (\Exception $e) {
                    // If batch insert fails, try individual inserts
                    foreach ($chunk as $record) {
                        try {
                            DB::table('patients')->insert($record);
                            // Add successful insert to our tracking array
                            $this->existingNames[] = strtolower(trim($record['Name']));
                        } catch (\Exception $e) {
                            Log::error('Error inserting individual record:', [
                                'error' => $e->getMessage(),
                                'record' => $record
                            ]);
                            $this->skippedRows++;
                        }
                    }
                }
            }
            $this->batch = []; // Clear the batch
        } catch (\Exception $e) {
            Log::error('Error inserting batch:', [
                'error' => $e->getMessage(),
                'batch_size' => count($this->batch)
            ]);
            $this->batch = []; // Clear the batch
        }
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.mrn' => 'required|string|max:255',
            '*.nationality_id' => 'nullable|max:255',
        ];
    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }

    public function batchSize(): int
    {
        return 500; // Insert 500 rows at a time
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getSkippedRows(): int
    {
        return $this->skippedRows;
    }

    public function onError(Throwable $e)
    {
        Log::error('Error during patient import:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'current_row' => $this->rowCount,
            'trace' => $e->getTraceAsString()
        ]);
        $this->skippedRows++;
    }

    public function __destruct()
    {
        // Insert any remaining records in the batch
        $this->insertBatch();
    }
}
