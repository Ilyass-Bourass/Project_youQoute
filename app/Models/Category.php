<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name'];

    public function quote(){
        return $this->belongsToMany(Quote::class,'categories_quotes');
    }

}
