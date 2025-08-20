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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_name');
            $table->string('member_nric')->unique();
            $table->string('member_mrn')->unique()->nullable();
            $table->string('member_email')->nullable();
            $table->string('member_phoneNum');
            $table->enum('member_gender', ['Male', 'Female']);
            $table->text('member_address')->nullable();
            $table->date('member_dob');
            $table->string('member_emergencyContactName');
            $table->string('member_emergencyContactPhone');
            $table->text('member_medicalConditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
