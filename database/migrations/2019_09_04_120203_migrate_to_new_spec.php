<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateToNewSpec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->integer('point')->default(1)->after('open');
            $table->dropColumn('image');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('point');
            $table->string('image', 200)->nullable()->before('open');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('point')->default(1)->after('image');
        });
    }
}
