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
        return $this->hasMany(Job::class);
    }

    public function countrySubdivisionItems() {
        return $this->hasMany(CountrySubdivisionItem::class);
    }
}
