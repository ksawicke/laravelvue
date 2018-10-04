<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $fillable = [
        'company_id',
        'street_address_1',
        'street_address_2',
        'country_id',
        'country_subdivision_item_id'
    ];
}
