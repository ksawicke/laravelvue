<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'country_subdivision_type_id'
    ];

    public function jobs() {
        return $this->hasMany('App\Job');
    }

    public function countrySubdivisionTypes() {
        return $this->belongsTo('App\CountrySubdivisionType');
    }

    public function countrySubdivisionItems() {
        return $this->hasMany('App\CountrySubdivisionItem');
    }
}
