<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSheetIdToMCaseContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_case_contents', function (Blueprint $table) {
            $table->integer('sheet_id')->after('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_case_contents', function (Blueprint $table) {
            $table->dropColumn('sheet_id');
        });
    }
}
