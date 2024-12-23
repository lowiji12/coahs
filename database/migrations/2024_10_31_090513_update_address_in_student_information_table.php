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
        Schema::table('student_information', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('student_information', 'address_region')) {
                $table->dropColumn('address_region');
            }
            if (Schema::hasColumn('student_information', 'address_province')) {
                $table->dropColumn('address_province');
            }
            if (Schema::hasColumn('student_information', 'address_municipality')) {
                $table->dropColumn('address_municipality');
            }
            // Add the single address column only if it doesn't exist
            if (!Schema::hasColumn('student_information', 'address')) {
                $table->string('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('student_information', function (Blueprint $table) {
            $table->string('address_region')->nullable();
            $table->string('address_province')->nullable();
            $table->string('address_municipality')->nullable();
            $table->dropColumn('address');
        });
    }
};
