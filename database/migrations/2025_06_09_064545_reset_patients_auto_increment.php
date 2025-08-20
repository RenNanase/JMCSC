<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, get the maximum ID
        $maxId = DB::table('patients')->max('id');

        // Reset the auto-increment to 1
        DB::statement("ALTER TABLE patients AUTO_INCREMENT = 1");

        // Update all IDs to be sequential starting from 1
        $patients = DB::table('patients')->orderBy('id')->get();
        $newId = 1;

        foreach ($patients as $patient) {
            DB::table('patients')
                ->where('id', $patient->id)
                ->update(['id' => $newId]);
            $newId++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need for down migration as this is a one-time fix
    }
};
