<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoryValue;

class CategoryValueFactory extends Factory
{
    protected $model = CategoryValue::class;

    public function definition()
    {
        return [
            'category_id' => 1, // تأكد أن لديك category_id صالح أو أنشئه Factory للـ Category
            'value' => $this->faker->word,
        ];
    }
}
