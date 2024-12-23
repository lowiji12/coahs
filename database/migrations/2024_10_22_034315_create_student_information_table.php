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
    Schema::create('student_information', function (Blueprint $table) {
        $table->string('student_number')->primary();
        $table->string('surname');
        $table->string('given_name');
        $table->string('middle_name')->nullable();
        $table->string('citizenship')->nullable();
        $table->string('gender');
        $table->string('indigenous')->nullable();
        $table->string('ethnicity')->nullable();
        $table->string('dialect')->nullable();
        $table->string('religion')->nullable();
        $table->date('birth_date');
        $table->string('birth_place')->nullable();
        $table->string('contact_number')->nullable();
        $table->string('civil_status')->nullable();
        $table->string('address_region')->nullable();
        $table->string('address_province')->nullable();
        $table->string('address_municipality')->nullable();
        $table->string('address')->nullable();
        $table->string('email_address')->nullable();
        $table->string('entry_type')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_information');
    }
};
