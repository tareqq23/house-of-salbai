<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManifestItem extends Model
{
    protected $guarded = [];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }
}
