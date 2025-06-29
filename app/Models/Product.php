<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'brand',
        'image_url',
        'stock_quantity',
        'is_active',
        'tags',
        'attributes',
    ];

    protected $casts = [
        'tags' => 'array',
        'attributes' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'product_merchant')
                    ->withPivot('merchant_price', 'merchant_stock', 'is_available')
                    ->withTimestamps();
    }

    public function interactions()
    {
        return $this->hasMany(UserInteraction::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }
} 