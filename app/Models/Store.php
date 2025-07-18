<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Store extends Model
{
    use HasFactory, BelongsTenantScope;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shippings()
    {
        return $this->hasMany(ShippingOption::class);
    }

    public function customers()
    {
        return $this->hasMany(User::class);
    }
}
