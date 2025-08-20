<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Remove unique constraints if they exist
            if (Schema::hasColumn('patients', 'mrn')) {
                $table->dropUnique(['mrn']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add back unique constraints if needed to rollback
            $table->unique('mrn');
        });
    }
};
