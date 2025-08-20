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
use Throwable;

class PatientsImport extends DefaultValueBinder implements
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

    public function bindValue(Cell $cell, $value)
    {
        if (is_null($value)) {
            $cell->setValueExplicit('', DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $mappedRow = [];
        foreach ($row as $key => $value) {
            $mappedRow[strtolower(trim($key))] = $value;
        }
        // We keep this log for verification, but it should now be consistent.
        Log::info('Mapped Row Keys (Lowercase) from Excel:', array_keys($mappedRow));
        return $mappedRow;
    }

    public function model(array $row)
    {
        // Access keys as lowercase, as map() converted them
        Log::info('Processing row:', $row);

        // Skip if required fields are empty (using lowercase keys)
        if (empty($row['name']) || empty($row['mrn'])) {
            Log::info('Skipping row - empty name or MRN:', $row);
            $this->skippedRows++;
            return null;
        }

        // Check if patient with this MRN already exists (using lowercase key for input)
        $existingPatient = Patient::where('MRN', $row['mrn'])->first();
        if ($existingPatient) {
            Log::info('Skipping row - duplicate MRN:', ['mrn' => $row['mrn'], 'existing_id' => $existingPatient->id]);
            $this->skippedRows++;
            return null;
        }

        // Convert nationality_id to string and handle empty values (using lowercase key for input)
        $nationalityId = null;
        if (isset($row['nationality_id']) && !empty($row['nationality_id'])) {
            $nationalityId = (string) $row['nationality_id'];
            if (strpos($nationalityId, 'E') !== false) {
                $nationalityId = number_format((float)$nationalityId, 0, '', '');
            }
        }

        $this->rowCount++;
        Log::info('Successfully importing row:', $row);
        return new Patient([
            'Name' => $row['name'], // Map to database column 'Name'
            'MRN' => $row['mrn'],   // Map to database column 'MRN'
            'Nationality_ID' => $nationalityId, // Map to database column 'Nationality_ID'
        ]);
    }

    public function rules(): array
    {
        return [
            // Use lowercase for validation rules, now that we know headers are lowercased
            '*.name' => 'required|string|max:255',
            '*.mrn' => 'required|string|max:255',
            '*.nationality_id' => 'nullable|max:255',
        ];
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 5000;
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
        // Log the error, or handle it as needed. For now, we'll just log it.
        Log::error('Error during patient import:', ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
        $this->skippedRows++; // Consider this row skipped due to error
    }
}
