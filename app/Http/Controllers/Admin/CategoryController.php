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
            'type' => 'required|in:select,text,number',
            'values' => 'nullable|array', // القيم يجب أن تكون مصفوفة
            'values.*' => 'required|string|max:255', // كل قيمة داخل المصفوفة يجب أن تكون نص
        ]);

        DB::transaction(function () use ($request) {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
            ]);

            if ($request->type === 'select' && $request->has('values')) {
                foreach ($request->values as $value) {
                    $category->values()->create(['value' => $value]);
                }
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
            'type' => 'required|in:select,text,number',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $category) {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
            ]);

            // حذف القيم القديمة وإضافة الجديدة إذا كان النوع select
            $category->values()->delete();
            if ($request->type === 'select' && $request->has('values')) {
                foreach ($request->values as $value) {
                    $category->values()->create(['value' => $value]);
                }
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف بنجاح.');
    }

    /**
     * حذف التصنيف من قاعدة البيانات.
     */
    public function destroy(Category $category)
    {
        // بفضل onDelete('cascade') في المايجريشن، سيتم حذف كل القيم تلقائيًا
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف التصنيف بنجاح.');
    }
}