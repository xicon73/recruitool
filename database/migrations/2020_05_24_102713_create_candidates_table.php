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
            $table->increments('id');
            $table->string('github_username');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('blog')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('hireable')->nullable();
            $table->string('bio')->nullable();
            $table->string('html_url');
            $table->integer('public_repos');
            $table->integer('followers');
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
