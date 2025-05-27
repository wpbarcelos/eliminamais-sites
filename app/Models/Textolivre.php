<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Textolivre extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function components()
    {
        return $this->morphMany(Component::class, 'componentable');
    }
}
