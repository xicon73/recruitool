<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'candidates';

    protected $fillable = ['github_username', 'name', 'company', 'avatar','blog','location','email','hirable','bio','number_of_public_repos','number_of_followers','job_category', 'skill_level', 'fit_for_job', 'commentary_notes'];
}
