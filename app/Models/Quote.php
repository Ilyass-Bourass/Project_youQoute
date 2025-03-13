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
}
