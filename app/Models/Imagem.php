<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'caption',
    ];

    public function components()
    {
        return $this->morphMany(Component::class, 'componentable');
    }
}
