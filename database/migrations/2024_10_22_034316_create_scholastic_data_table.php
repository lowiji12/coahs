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
        Schema::create('scholastic_data', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->foreign('student_number')->references('student_number')->on('student_information')->onDelete('cascade');
            $table->string('elem_school_name')->nullable();
            $table->string('elem_school_year')->nullable();
            $table->string('elem_school_address')->nullable();
            $table->string('jh_school_name')->nullable();
            $table->string('jh_school_year')->nullable();
            $table->string('jh_address_region')->nullable();
            $table->string('jh_address_province')->nullable();
            $table->string('jh_address_municipality')->nullable();
            $table->string('jh_address_barangay')->nullable();
            $table->string('sh_school_name')->nullable();
            $table->string('sh_school_strand')->nullable();
            $table->string('sh_school_year')->nullable();
            $table->string('sh_address_region')->nullable();
            $table->string('sh_address_province')->nullable();
            $table->string('sh_address_municipality')->nullable();
            $table->string('sh_address_barangay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholastic_data');
    }
};
