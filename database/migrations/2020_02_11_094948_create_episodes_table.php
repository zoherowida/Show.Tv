<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seriesTv_id');
            $table->string('title');
            $table->longText('description');
            $table->string('show_time');
            $table->string('video');
            $table->string('thumbnail');
            $table->string('duration');
            $table->softDeletes();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 1',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 2',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 3',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 4',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 5',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 6',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 7',
                'seriesTv_id' => 1,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 1',
                'seriesTv_id' => 2,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
            )
        );
        // Insert some stuff
        DB::table('episodes')->insert(
            array(
                'title' => 'episodes 2',
                'seriesTv_id' => 2,
                'description' => 'Description',
                'show_time' => '["day":"Monday" ,"time":"8:30PM"]',
                'video' => 'https://www.youtube.com/watch?v=d9BQS3sStg0&t',
                'thumbnail' => 'film1.jpeg',
                'duration' => '19:22',
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
        Schema::dropIfExists('episodes');
    }
}
