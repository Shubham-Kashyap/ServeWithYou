<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catagories extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
    ];
 	
    protected $hidden = [
        'token',
    ];
}
