<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;

class GenerateMemberScrn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:generate-scrn {--force : Force regeneration of existing SCRNs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SCRN (Senior Care Running Number) for existing members';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting SCRN generation for members...');

        $force = $this->option('force');
        
        if ($force) {
            $this->info('Force mode enabled - will regenerate all SCRNs');
            $members = Member::all();
        } else {
            $members = Member::whereNull('scrn')->get();
        }

        if ($members->isEmpty()) {
            $this->info('No members found that need SCRN generation.');
            return;
        }

        $this->info('Found ' . $members->count() . ' member(s) to process.');

        $progressBar = $this->output->createProgressBar($members->count());
        $progressBar->start();

        $updated = 0;
        $errors = 0;

        foreach ($members as $member) {
            try {
                if ($force) {
                    // For force mode, directly update the SCRN
                    $scrn = 'SC' . str_pad($member->id, 5, '0', STR_PAD_LEFT);
                    $member->updateQuietly(['scrn' => $scrn]);
                } else {
                    $member->generateScrn();
                }
                $updated++;
            } catch (\Exception $e) {
                $errors++;
                $this->error('\nFailed to generate SCRN for member ID ' . $member->id . ': ' . $e->getMessage());
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->newLine();
        $this->info('SCRN generation completed!');
        $this->info('Successfully processed: ' . $updated . ' member(s)');
        
        if ($errors > 0) {
            $this->error('Errors encountered: ' . $errors . ' member(s)');
        }

        // Show some sample results
        $this->newLine();
        $this->info('Sample SCRNs generated:');
        $samples = Member::whereNotNull('scrn')->orderBy('id')->limit(5)->get(['id', 'scrn', 'member_name']);
        
        foreach ($samples as $sample) {
            $this->line('  ID: ' . $sample->id . ' -> SCRN: ' . $sample->scrn . ' (' . $sample->member_name . ')');
        }
    }
}
