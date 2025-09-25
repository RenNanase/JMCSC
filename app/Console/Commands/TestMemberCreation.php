<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;

class TestMemberCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:member-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test member creation with SCRN generation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing member creation like the form...');
        
        try {
            // Simulate the same data that comes from the registration form
            $formData = [
                'member_name' => 'Test Form User',
                'member_nric' => 'FORM12345' . time(),
                'member_mrn' => null,
                'member_email' => 'formtest@example.com',
                'member_phoneNum' => '987654321',
                'member_gender' => 'Female',
                'member_address' => '123 Test Street',
                'member_dob' => '1995-05-15',
                'is_ecard_given' => false
            ];
            
            $this->info('Creating member with form-like data...');
            $member = Member::create($formData);
            
            $this->info("✅ Member created successfully!");
            $this->info("   ID: {$member->id}");
            $this->info("   SCRN: {$member->scrn}");
            $this->info("   Name: {$member->member_name}");
            
            // Test the scrn property access specifically
            $this->info('Testing SCRN property access:');
            $this->info("   Direct scrn: {$member->scrn}");
            $this->info("   Attributes scrn: " . ($member->getAttributes()['scrn'] ?? 'NULL'));
            
            // Clean up
            $member->delete();
            $this->info('✅ Test member deleted successfully.');
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('Stack trace:');
            $this->error($e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }
}
