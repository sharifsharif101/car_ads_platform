<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Car;
use App\Models\CategoryValue;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_car_successfully()
    {
        $category = CategoryValue::factory()->create();

        \Storage::fake('public');

        $response = $this->post(route('admin.cars.store'), [
            'title' => 'سيارة تويوتا',
            'description' => 'وصف السيارة',
            'price' => 150000,
            'status' => 'active',
            'main_image' => UploadedFile::fake()->image('main.jpg'),
            'images' => [
                UploadedFile::fake()->image('extra1.jpg'),
                UploadedFile::fake()->image('extra2.jpg'),
            ],
            'categories' => [
                $category->category_id => $category->id
            ],
            'tags' => ['تويوتا', 'جديدة']
        ]);

        $response->assertRedirect(route('admin.cars.index'));
        $this->assertDatabaseHas('cars', ['title' => 'سيارة تويوتا']);
        $this->assertDatabaseCount('car_images', 2);
        $this->assertDatabaseHas('car_tag', ['car_id' => Car::first()->id]);
    }
}
