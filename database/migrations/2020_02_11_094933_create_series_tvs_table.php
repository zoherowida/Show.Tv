<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_tvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->string('airing_time');
            $table->softDeletes();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('series_tvs')->insert(
            array(
                'title' => 'series 1',
                'description' => 'Description',
                'airing_time' => '["start":"Monday","end":"Thursday","time":"8:30PM"]',
            )
        );
        // Insert some stuff
        DB::table('series_tvs')->insert(
            array(
                'title' => 'series 2',
                'description' => 'Description',
                'airing_time' => '["start":"Monday","end":"Thursday","time":"8:30PM"]',
            )
        );
        // Insert some stuff
        DB::table('series_tvs')->insert(
            array(
                'title' => 'series 3',
                'description' => 'Description',
                'airing_time' => '["start":"Monday","end":"Thursday","time":"8:30PM"]',
            )
        );
        // Insert some stuff
        DB::table('series_tvs')->insert(
            array(
                'title' => 'series 4',
                'description' => 'Description',
                'airing_time' => '["start":"Monday","end":"Thursday","time":"8:30PM"]',
            )
        );
        // Insert some stuff
        DB::table('series_tvs')->insert(
            array(
                'title' => 'series 5',
                'description' => 'Description',
                'airing_time' => '["start":"Monday","end":"Thursday","time":"8:30PM"]',
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_tvs');
    }
}
