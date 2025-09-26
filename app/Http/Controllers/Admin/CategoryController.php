<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * عرض جميع التصنيفات.
     */
    public function index()
    {
        $categories = Category::with('values')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * عرض فورم إنشاء تصنيف جديد.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * تخزين تصنيف جديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'values' => 'required|array|min:1', // القيم الآن مطلوبة ويجب أن تحتوي على عنصر واحد على الأقل
            'values.*' => 'required|string|max:255', // كل قيمة داخل المصفوفة يجب أن تكون نص
        ]);

        DB::transaction(function () use ($request) {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
                // 'type' => 'select', // لم نعد بحاجة لحفظ النوع، أو يمكننا تثبيته
            ]);

            // بما أن كل التصنيفات لها قيم، لم نعد بحاجة للتحقق من النوع
            foreach ($request->values as $value) {
                $category->values()->create(['value' => $value]);
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'تم إنشاء التصنيف بنجاح.');
    }

    /**
     * عرض فورم تعديل تصنيف معين.
     */
    public function edit(Category $category)
    {
        $category->load('values'); // تحميل القيم المرتبطة
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * تحديث بيانات التصنيف في قاعدة البيانات.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $category) {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);

            // حذف القيم القديمة وإضافة الجديدة دائمًا
            $category->values()->delete();
            foreach ($request->values as $value) {
                $category->values()->create(['value' => $value]);
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف بنجاح.');
    }

    /**
     * حذف التصنيف من قاعدة البيانات.
     */
    public function destroy(Category $category)
    {
        // يفضل استخدام transaction هنا لضمان حذف التصنيف وقيمه معًا
        // على الرغم من أن onDelete('cascade') يقوم بذلك على مستوى قاعدة البيانات
        // إلا أن هذا يوفر طبقة أمان إضافية على مستوى التطبيق.
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف التصنيف بنجاح.');
    }
}