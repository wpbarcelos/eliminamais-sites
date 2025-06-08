<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'original_name',
        'mime_type',
        'file_size',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
    ];

    public function components()
    {
        return $this->morphMany(Component::class, 'componentable');
    }

    public function scopeByMimeType($query, $mimeType)
    {
        return $query->where('mime_type', $mimeType);
    }

    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopePdfs($query)
    {
        return $query->where('mime_type', 'application/pdf');
    }

    public function scopeDocuments($query)
    {
        return $query->whereIn('mime_type', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isPdf()
    {
        return $this->mime_type === 'application/pdf';
    }
}