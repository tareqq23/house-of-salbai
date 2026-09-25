<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function previewGallery()
    {
        return $this->belongsTo(Gallery::class, 'preview_gallery_id');
    }
}
