<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('code');
            $table->text('short_description');
            $table->text('long_description');
            $table->smallInteger('hourly_rate_min')->unsigned();
            $table->smallInteger('hourly_rate_max')->unsigned();
            $table->smallInteger('salary_min')->unsigned();
            $table->smallInteger('salary_max')->unsigned();
            $table->tinyInteger('duration_int')->unsigned();
            $table->text('duration_unit');
            $table->text('preferred_skills');
            $table->integer('company_id')->unsigned();
            $table->integer('company_location_id')->unsigned();
            $table->integer('education_level_id');
            $table->smallInteger('min_education_years')->unsigned();
            $table->boolean('travel');
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
