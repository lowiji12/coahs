<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('student_clinical_basal_data', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->foreign('student_number')->references('student_number')->on('student_information')->onDelete('cascade');
            $table->integer('age');
            $table->integer('height');
            $table->integer('weight');
            $table->string('blood_type')->nullable();
            $table->string('disabilities')->nullable();
            $table->date('date_diagnosed')->nullable();
            $table->string('hdi1')->nullable();
            $table->date('hdi1_date')->nullable();
            $table->string('hdi2')->nullable();
            $table->date('hdi2_date')->nullable();
            $table->string('allergy_med')->nullable();
            $table->string('allergy_food')->nullable();
            $table->string('allergy_others')->nullable();
            $table->string('medication1')->nullable();
            $table->string('medication2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_clinical_basal_data');
    }
};
