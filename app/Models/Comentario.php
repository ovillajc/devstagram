<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    public function user()
    {
        // Relacion inversa comentario pertenece a usuario
        return $this->belongsTo(User::class);
    }
}
