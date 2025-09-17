<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CategoryValue; // تأكد من استدعاء الموديل

class Category extends Model
{
   use HasFactory;

    protected $fillable = ['name', 'slug', 'type'];

    public function values()
    {
        return $this->hasMany(CategoryValue::class);
    }
      public function categoryValues()
    {
        return $this->hasMany(CategoryValue::class);
    }
}
