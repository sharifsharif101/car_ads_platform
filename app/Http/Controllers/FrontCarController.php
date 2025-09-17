<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Category;
use App\Models\Tag;

class FrontCarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query()
            ->with(['tags', 'categoryValues.category', 'images'])
            ->where('status', 'active');

        // Text search (title or description)
        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Price range
        if ($min = $request->get('min_price')) {
            $query->where('price', '>=', (float)$min);
        }
        if ($max = $request->get('max_price')) {
            $query->where('price', '<=', (float)$max);
        }

        // Filter by a tag name
        if ($tag = trim((string) $request->get('tag'))) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('name', $tag);
            });
        }

        // Filter by category (by category_id)
 if ($categoryId = $request->get('category_id')) {
    // ابحث عن التصنيف المختار مع كل أبنائه (بشكل متداخل)
    $category = Category::with('allChildren')->find($categoryId);

    if ($category) {
        // دالة لجمع كل معرفات الأبناء في مصفوفة واحدة
        function collectIds($category) {
            $ids = [$category->id];
            foreach ($category->allChildren as $child) {
                $ids = array_merge($ids, collectIds($child));
            }
            return $ids;
        }

        $categoryIds = collectIds($category);

        $query->whereHas('categoryValues', function ($q) use ($categoryIds) {
            $q->whereIn('category_values.category_id', $categoryIds);
        });
    }
}

        // Filter by a specific category value (value_id)
        if ($valueId = $request->get('value_id')) {
            $query->whereHas('categoryValues', function ($q) use ($valueId) {
                $q->where('category_values.id', $valueId);
            });
        }

        $cars = $query->latest()->paginate(12)->withQueryString();

        // Data for filter UI
        $categories = Category::with('values')->get();
        $tags = Tag::orderBy('name')->get();

        return view('cars.index', [
            'cars' => $cars,
            'categories' => $categories,
            'tags' => $tags,
            'filters' => [
                'q' => $request->get('q'),
                'min_price' => $request->get('min_price'),
                'max_price' => $request->get('max_price'),
                'tag' => $request->get('tag'),
                'category_id' => $request->get('category_id'),
                'value_id' => $request->get('value_id'),
            ],
        ]);
    }


     public function show(Car $car)
    {
        // التأكد من أن الإعلان فعال قبل عرضه للعامة
        if ($car->status !== 'active') {
            abort(404);
        }
        
        // جلب كل العلاقات المطلوبة لعرضها في صفحة التفاصيل
        $car->load(['tags', 'categoryValues.category', 'images']);

        return view('cars.show', [
            'car' => $car,
        ]);
    }
}