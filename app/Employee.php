<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni', 
        'code',
        'names',
        'surname',
        'profile',
        'date_of_birth',
        'phone',
        'gender',
        'address',
        'email'

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}