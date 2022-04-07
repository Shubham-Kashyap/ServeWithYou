<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{


	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'dimension',
        'size_type',
        'catagory_id',
        'weight',
        'weight_type',
        'location',
        'lat',
        'long',
        'listing_validity',
        'images'
    ];
 	
    protected $hidden = [
        'token',
    ];

  
}
