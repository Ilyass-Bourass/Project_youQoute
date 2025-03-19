<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    protected $fillable=[
        'content_text',
        'auteur',
        'source',
        'nombre_mots',
        'nombre_vues',
         'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(category::class,'categories_quotes');
    }

    public function tags(){
        return $this->belongsToMany(tag::class,'tags_quotes')->withTimestamps();
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function mesFavorites(){
        return $this->hasMany(MesFavorite::class);
    }
}
