<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = ['name',
                           'description',
                           'html_url',
                           'stargazers_count',
                           'watchers',
                           'language',
                           'forks',
                           'open_issues',
                           'candidate_id'
                        ];

    public function candidate() {
        return $this->belongsTo(Candidate::class);
    }
}
