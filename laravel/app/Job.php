<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'code',
        'short_description',
        'long_description',
        'hourly_rate_min',
        'hourly_rate_max',
        'salary_min',
        'salary_max',
        'duration_int',
        'duration_unit',
        'preferred_skills',
        'company_id',
        'education_level_id',
        'min_education_years',
        'travel'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
