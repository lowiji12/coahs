<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChemicalsTable extends Migration
{
    public function up()
    {
        Schema::create('chemicals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand_name');
            $table->integer('stock');
            $table->date('expire_date');
            $table->string('location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chemicals');
    }
}