<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountrySubdivisionItem extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'abbreviation'
    ];

    public function country() {
        return $this->belongsTo('App\Country');
    }
}
