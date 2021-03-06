<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'website',
        'phone',
        'social_linked_in',
        'social_twitter',
        'social_facebook',
        'about'
    ];

    public function jobs() {
        return $this->hasMany('App\Job');
    }

    public function locations() {
        return $this->hasMany('App\CompanyLocation');
    }
}
