<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryValue extends Model
{
   use HasFactory;

    protected $fillable = ['category_id', 'value'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_category_values', 'value_id', 'car_id');
    }
}
