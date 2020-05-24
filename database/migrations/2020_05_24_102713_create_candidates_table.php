<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('github_username');
            $table->string('name');
            $table->string('company');
            $table->string('avatar');
            $table->string('blog');
            $table->string('location');
            $table->string('email');
            $table->string('hireble');
            $table->string('bio');
            $table->integer('number_of_public_repos');
            $table->integer('number_of_followers');
            $table->string('job_category');
            $table->string('skill_level');
            $table->integer('fit_for_job');
            $table->text('commentary_notes');
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
        Schema::dropIfExists('candidates');
    }
}
