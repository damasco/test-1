<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getCategoryIds()
    {
        return $this->categories()->pluck('category_id')->all();
    }
}
