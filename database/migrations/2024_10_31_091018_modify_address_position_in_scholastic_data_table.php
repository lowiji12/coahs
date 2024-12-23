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
            // Move `jh_address` to after `jh_school_name` and `sh_address` to after `sh_school_name`
            $table->string('jh_address')->nullable()->after('jh_school_name')->change();
            $table->string('sh_address')->nullable()->after('sh_school_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Since the `after` position is only a visual positioning, there's typically no need to revert
        // this kind of change. The down method is empty, as it would not affect data or structure.
    }
};
