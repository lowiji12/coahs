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
        Schema::create('parent_guardian_data', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->foreign('student_number')->references('student_number')->on('student_information')->onDelete('cascade');
            $table->string('parent_fullname');
            $table->string('parent_contact_number')->nullable();
            $table->string('parent_address')->nullable();
            $table->string('parent_relationship')->nullable();
            $table->boolean('house')->nullable();
            $table->boolean('parent_as_guardian')->nullable();
            $table->string('guardian_fullname')->nullable();
            $table->string('guardian_contact_number')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_guardian_data');
    }
};
