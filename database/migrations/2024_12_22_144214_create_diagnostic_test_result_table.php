<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diagnostic_test_results', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->string('school_year');
            $table->string('semester');
            
            // Complete Blood Count
            $table->binary('complete_blood_count')->nullable();
            $table->text('complete_blood_count_note')->nullable();
            $table->string('complete_blood_count_remark')->nullable();
            $table->timestamp('complete_blood_count_upload_date')->nullable();
            
            // Chest X-ray
            $table->binary('chest_xray')->nullable();
            $table->text('chest_xray_note')->nullable();
            $table->string('chest_xray_remark')->nullable();
            $table->timestamp('chest_xray_upload_date')->nullable();
            
            // Drug Test
            $table->binary('drug_test')->nullable();
            $table->text('drug_test_note')->nullable();
            $table->string('drug_test_remark')->nullable();
            $table->timestamp('drug_test_upload_date')->nullable();
            
            // Hearing Test
            $table->binary('hearing_test')->nullable();
            $table->text('hearing_test_note')->nullable();
            $table->string('hearing_test_remark')->nullable();
            $table->timestamp('hearing_test_upload_date')->nullable();
            
            // Hepatitis B
            $table->binary('hepatitis_b')->nullable();
            $table->text('hepatitis_b_note')->nullable();
            $table->string('hepatitis_b_remark')->nullable();
            $table->timestamp('hepatitis_b_upload_date')->nullable();
            
            // Fecalysis
            $table->binary('fecalysis')->nullable();
            $table->text('fecalysis_note')->nullable();
            $table->string('fecalysis_remark')->nullable();
            $table->timestamp('fecalysis_upload_date')->nullable();
            
            // Urinalysis
            $table->binary('urinalysis')->nullable();
            $table->text('urinalysis_note')->nullable();
            $table->string('urinalysis_remark')->nullable();
            $table->timestamp('urinalysis_upload_date')->nullable();
            
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('student_number')
                  ->references('student_number')
                  ->on('student_information')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnostic_test_results');
    }
};