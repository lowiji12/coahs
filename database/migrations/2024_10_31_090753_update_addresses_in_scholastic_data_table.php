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
        Schema::table('scholastic_data', function (Blueprint $table) {
            // Drop specific address fields if they exist
            if (Schema::hasColumn('scholastic_data', 'jh_address_region')) {
                $table->dropColumn('jh_address_region');
            }
            if (Schema::hasColumn('scholastic_data', 'jh_address_province')) {
                $table->dropColumn('jh_address_province');
            }
            if (Schema::hasColumn('scholastic_data', 'jh_address_municipality')) {
                $table->dropColumn('jh_address_municipality');
            }
            if (Schema::hasColumn('scholastic_data', 'jh_address_barangay')) {
                $table->dropColumn('jh_address_barangay');
            }
            if (Schema::hasColumn('scholastic_data', 'sh_address_region')) {
                $table->dropColumn('sh_address_region');
            }
            if (Schema::hasColumn('scholastic_data', 'sh_address_province')) {
                $table->dropColumn('sh_address_province');
            }
            if (Schema::hasColumn('scholastic_data', 'sh_address_municipality')) {
                $table->dropColumn('sh_address_municipality');
            }
            if (Schema::hasColumn('scholastic_data', 'sh_address_barangay')) {
                $table->dropColumn('sh_address_barangay');
            }

            // Add single address fields for junior high and senior high
            $table->string('jh_address')->nullable();
            $table->string('sh_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('scholastic_data', function (Blueprint $table) {
            // Restore specific address fields for junior high and senior high
            $table->string('jh_address_region')->nullable();
            $table->string('jh_address_province')->nullable();
            $table->string('jh_address_municipality')->nullable();
            $table->string('jh_address_barangay')->nullable();
            $table->string('sh_address_region')->nullable();
            $table->string('sh_address_province')->nullable();
            $table->string('sh_address_municipality')->nullable();
            $table->string('sh_address_barangay')->nullable();

            // Drop the single address fields
            $table->dropColumn('jh_address');
            $table->dropColumn('sh_address');
        });
    }
};
