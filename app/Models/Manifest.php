<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'additional_items' => 'array'
    ];

    public function items()
    {
        return $this->hasMany(ManifestItem::class);
    }
}
