<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'price', 'image', 'quantity', 'is_archived'];

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'price' => 'integer',
        'quantity' => 'integer',
        'is_archived' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
