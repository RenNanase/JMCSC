<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class FixScrnSequencing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:fix-scrn-sequencing {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix SCRN sequencing to be sequential (SC00001, SC00002, etc.) regardless of ID gaps';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $memberCount = Member::count();
        
        $this->info("Found {$memberCount} members in the database.");
        $this->info("This will reassign SCRNs from SC00001 to SC" . str_pad($memberCount, 5, '0', STR_PAD_LEFT));
        
        if (!$this->option('force') && !$this->confirm('Do you want to proceed with fixing SCRN sequencing?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info('Starting SCRN sequencing fix...');
        
        // Get all members ordered by ID to maintain some consistency
        $members = Member::orderBy('id')->get();
        
        $progressBar = $this->output->createProgressBar($members->count());
        $progressBar->start();
        
        $counter = 1;
        $updatedCount = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($members as $member) {
                $newScrn = 'SC' . str_pad($counter, 5, '0', STR_PAD_LEFT);
                
                // Only update if SCRN is different
                if ($member->scrn !== $newScrn) {
                    $member->scrn = $newScrn;
                    $member->save();
                    $updatedCount++;
                }
                
                $counter++;
                $progressBar->advance();
            }
            
            DB::commit();
            
            $progressBar->finish();
            $this->newLine(2);
            $this->info("✅ Successfully updated {$updatedCount} member SCRNs.");
            $this->info("📋 Total members: {$memberCount}");
            $this->info("🏷️  SCRN range: SC00001 to SC" . str_pad($memberCount, 5, '0', STR_PAD_LEFT));
            
        } catch (\Exception $e) {
            DB::rollBack();
            $progressBar->finish();
            $this->newLine();
            $this->error("❌ Error occurred: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
