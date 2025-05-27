<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'type',
        'order',
        'componentable_id',
        'componentable_type',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function componentable()
    {
        return $this->morphTo();
    }
}
