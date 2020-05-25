<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'candidates';

    protected $fillable = ['github_username',
                           'name',
                           'company',
                           'avatar_url',
                           'blog',
                           'location',
                           'email',
                           'hireable',
                           'bio',
                           'html_url',
                           'public_repos',
                           'followers',
                           'job_category',
                           'skill_level',
                           'fit_for_job',
                           'commentary_notes'
                        ];

    public function repositories() {
        return $this->hasMany(Repository::class);
    }
}
