<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'subdomain_id',
        'title',
        'slug',
    ];

    public function subdomain()
    {
        return $this->belongsTo(Subdomain::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class)
            ->orderBy('order', 'asc');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
