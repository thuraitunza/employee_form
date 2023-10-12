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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nrc_id')->constrained()->cascadeOnDelete();
            $table->foreignId('education_id')->constrained()->cascadeOnDelete();
            $table->foreignId('experence_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->constrained()->cascadeOnDelete();
            $table->string('eng_name');
            $table->string('mm_name');
            $table->string('father_name');
            $table->string('date_of_birth');
            $table->string('race');
            $table->string('religion');
            $table->string('nationality');
            $table->string('vacancy');
            $table->string('passport_no');
            $table->string('driver_license_no');
            $table->string('gender');
            $table->string('blood_type');
            $table->string('marital_status');
            $table->string('home_phone');
            $table->string('mobile_phone');
            $table->string('social_media_url');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
