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
    Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('generic_name');
        $table->string('brand_name');
        $table->string('dose');
        $table->string('form');
        $table->string('location');
        $table->integer('stock');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
