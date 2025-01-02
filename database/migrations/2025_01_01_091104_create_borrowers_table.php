<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('course');
            $table->string('year_level');
            $table->enum('category', ['CHEMICALS', 'EQUIPMENTS', 'INSTRUMENTS', 'MEDICINES', 'SUPPLIES']);
            $table->string('borrowed_item');
            $table->date('borrowed_date');
            $table->integer('quantity_borrowed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowers');
    }
}
