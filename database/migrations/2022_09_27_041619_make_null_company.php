<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNullCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quarries', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `quarries` MODIFY `company_id` BIGINT UNSIGNED NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quarries', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `quarries` MODIFY `company_id` BIGINT UNSIGNED NOT NULL;');
        });
    }
}
