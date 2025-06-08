<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Subdomain extends Model
{
    use HasFactory;
    use HasSEO;


    protected $fillable = [
        'name',
        'domain',
        'codigo',
        'image',
        'description'
    ];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function getDynamicSEOData(): SEOData
    {

        $seoData = new SEOData(
            title: $this->title,
            description: $this->description,
            image: Storage::url($this->image),
            site_name: $this->name,
            url: $this->url
        );
        return $seoData;
    }
}
