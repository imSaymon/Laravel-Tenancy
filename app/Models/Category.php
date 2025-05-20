<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, BelongsTenantScope;

    protected $fillable = ['name', 'description'];

    public function setNameAttribute($prop)
    {
        $this->attributes['name'] = $prop;
        $this->attributes['slug'] = Str::slug($prop);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
