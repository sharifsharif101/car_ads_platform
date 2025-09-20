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
            ->with(['categoryValues.category', 'images'])
            // تعديل: جلب الإعلانات النشطة وغير المتوفرة، واستبعاد المنتهية والتي قيد المراجعة
            ->whereIn('status', ['active', 'inactive']);


        // Text search (title or description) - يعمل بشكل صحيح
        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Price range - يعمل بشكل صحيح
        if ($min = $request->get('min_price')) {
            $query->where('price', '>=', (float)$min);
        }
        if ($max = $request->get('max_price')) {
            $query->where('price', '<=', (float)$max);
        }

        // ======================= الجزء الذي تم تعديله ======================= //
        // Filter by multiple category values from the form
        if ($categoryValues = $request->get('category_values')) {
            // نتأكد أنها مصفوفة
            if (is_array($categoryValues)) {
                foreach ($categoryValues as $categoryId => $valueId) {
                    // نتجاهل القيم الفارغة (عندما يختار المستخدم "الكل")
                    if ($valueId) {
                        // نضيف شرط لكل قيمة مختارة
                        // هذا يضمن أن السيارة يجب أن تحتوي على كل المواصفات المختارة
                        $query->whereHas('categoryValues', function ($q) use ($valueId) {
                            $q->where('category_values.id', $valueId);
                        });
                    }
                }
            }
        }
        // ======================= نهاية الجزء المعدّل ======================= //


        $cars = $query->latest()->paginate(12)->withQueryString();

        // Data for filter UI
        $categories = Category::with('values')->get();

        // لا حاجة لإرجاع قيم الفلاتر القديمة category_id و value_id
        return view('cars.index', [
            'cars' => $cars,
            'categories' => $categories,
        ]);
    }


     public function show(Car $car)
    {
        // التأكد من أن الإعلان فعال قبل عرضه للعامة
        if ($car->status !== 'active') {
            abort(404);
        }
        
        // جلب كل العلاقات المطلوبة لعرضها في صفحة التفاصيل
        $car->load(['categoryValues.category', 'images']);

        return view('cars.show', [
            'car' => $car,
        ]);
    }
}