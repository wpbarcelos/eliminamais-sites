<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Page extends Model
{
    use HasFactory;
    use HasSEO;

    protected $fillable = [
        'subdomain_id',
        'title',
        'slug',
        'image',
        'image_icon'
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

    public function getDynamicSEOData(): SEOData
    {

        $seoData = new SEOData(
            title: $this->title,
            description: $this->description,
            image: Storage::url($this->image_icon),
            site_name: $this->subdomain->name,
            url: $this->subdomain->url . '/' . $this->slug
        );
        return $seoData;
    }
}
