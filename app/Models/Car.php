<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\CarImage;
 
use App\Models\CategoryValue;
class Car extends Model
{
       use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'seats',
        'main_image',
        'status',
        'views',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
{
    return $this->hasMany(CarImage::class);
}

public function categories()
{
    // The foreign key for CategoryValue in the pivot table is 'value_id', not the conventional 'category_value_id'.
    // We need to specify it explicitly.
    return $this->belongsToMany(CategoryValue::class, 'car_category_values', 'car_id', 'value_id')
                ->withPivot('category_id');
}
 

    public function categoryValues()
    {
        //              اسم الموديل المرتبط, اسم الجدول الوسيط, المفتاح الأجنبي للموديل الحالي, المفتاح الأجنبي للموديل المرتبط
        return $this->belongsToMany(CategoryValue::class, 'car_category_values', 'car_id', 'value_id')
            ->withPivot('category_id') // مهم جدًا لجلب category_id أيضًا
            ->withTimestamps();
    }

}
