<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'recipe';
    protected $fillable = ['name','cuisine','type','ingredients','directions','other_notes','nutrition_facts'];

}
