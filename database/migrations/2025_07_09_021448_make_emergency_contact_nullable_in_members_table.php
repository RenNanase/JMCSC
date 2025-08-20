<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('member_emergencyContactName')->nullable()->change();
            $table->string('member_emergencyContactPhone')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('member_emergencyContactName')->nullable(false)->change();
            $table->string('member_emergencyContactPhone')->nullable(false)->change();
        });
    }
};
