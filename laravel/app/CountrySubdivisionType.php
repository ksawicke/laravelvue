<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountrySubdivisionType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function countries() {
        return $this->hasMany('App\Country');
    }
}
