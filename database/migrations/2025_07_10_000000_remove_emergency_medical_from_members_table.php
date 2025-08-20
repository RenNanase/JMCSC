<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'member_emergencyContactName')) {
                $table->dropColumn('member_emergencyContactName');
            }
            if (Schema::hasColumn('members', 'member_emergencyContactPhone')) {
                $table->dropColumn('member_emergencyContactPhone');
            }
            if (Schema::hasColumn('members', 'member_medicalConditions')) {
                $table->dropColumn('member_medicalConditions');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('member_emergencyContactName')->nullable();
            $table->string('member_emergencyContactPhone')->nullable();
            $table->text('member_medicalConditions')->nullable();
        });
    }
};
