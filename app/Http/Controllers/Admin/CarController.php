<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;
use App\Models\CategoryValue;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with(['images', 'categoryValues'])->latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }
     public function create()
    {
        $categories = Category::with('categoryValues')->get();
        return view('admin.cars.create', compact('categories'));
    }
    // حفظ الإعلان الجديد
 public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'status' => 'required|in:active,inactive,pending,expired',
        'main_image' => 'required|image|max:5120',
        'images.*' => 'nullable|image|max:5120',
        'categories.*' => 'nullable|exists:category_values,id'
    ]);

    $car = Car::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'status' => $request->status,
        'main_image' => $request->file('main_image')->store('cars', 'public_uploads'),
        'user_id' => 1,
    ]);

    // حفظ الصور الإضافية
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $image->store('cars', 'public_uploads') // ✅ تعديل هنا
            ]);
        }
    }

    // ربط التصنيفات
    if ($request->filled('categories')) {
        foreach ($request->categories as $cat_id => $value_id) {
            if ($value_id) {
                $car->categoryValues()->attach($value_id, ['category_id' => $cat_id]);
            }
        }
    }

    // ربط الوسوم
    if ($request->tags) {
        $tagsIds = [];
        foreach ($request->tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagsIds[] = $tag->id;
        }
        $car->tags()->sync($tagsIds);
    }

    return redirect()->route('admin.cars.index')->with('success', 'تم إنشاء الإعلان بنجاح');
}


    // صفحة تعديل الإعلان

    public function edit(Car $car)
    {
        $categories = Category::with('values')->get();
 
        $car->load(['images', 'categoryValues']);

        return view('admin.cars.edit', compact('car', 'categories'));
    }
    public function update(Request $request, Car $car)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive,pending,expired',
            'main_image' => 'nullable|image|max:5120',
            'images.*' => 'nullable|image|max:5120',
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|exists:category_values,id',
            'tags' => 'nullable|array',
        ]);

        $data = $request->only('title', 'description', 'price', 'status');

        if ($request->hasFile('main_image')) {
            // حذف الصورة القديمة إذا أردت
            $data['main_image'] = $request->file('main_image')->store('cars', 'public');
        }

        $car->update($data);

        // تحديث الصور الإضافية
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $image->store('cars', 'public')
                ]);
            }
        }

        // تحديث التصنيفات
        $syncData = [];
        if ($request->filled('categories')) {
            foreach ($request->categories as $categoryId => $valueId) {
                if ($valueId) {
                    $syncData[$valueId] = ['category_id' => $categoryId];
                }
            }
        }
        $car->categoryValues()->sync($syncData);
        return redirect()->route('admin.cars.index')->with('success', 'تم تحديث الإعلان بنجاح');
    }

    // حذف الإعلان
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'تم حذف الإعلان بنجاح');
    }

    // حذف صورة إضافية
    public function destroyImage(CarImage $image)
    {
        // التأكد من أن المستخدم لديه صلاحية حذف هذه الصورة (اختياري لكنه جيد للأمان)
        // $this->authorize('delete', $image);

        // حذف الملف من مساحة التخزين
        Storage::disk('public')->delete($image->image_path);

        // حذف السجل من قاعدة البيانات
        $image->delete();

        return back()->with('success', 'تم حذف الصورة بنجاح.');
    }
}
