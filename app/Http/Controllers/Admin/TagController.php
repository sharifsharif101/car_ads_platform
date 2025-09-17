<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * عرض قائمة بكل الوسوم.
     */
    public function index()
    {
        // withCount('cars') لجلب عدد السيارات المرتبطة بكل وسم لزيادة الفائدة
        $tags = Tag::withCount('cars')->latest()->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * عرض نموذج إنشاء وسم جديد.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * تخزين وسم جديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name|max:255',
        ]);

        Tag::create($request->all());

        return redirect()->route('admin.tags.index')
                         ->with('success', 'تم إنشاء الوسم بنجاح.');
    }

    /**
     * عرض نموذج تعديل وسم موجود.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * تحديث بيانات وسم موجود في قاعدة البيانات.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            // تأكد من أن الاسم فريد، لكن تجاهل الوسم الحالي عند التحقق
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->ignore($tag->id)],
        ]);

        $tag->update($request->all());

        return redirect()->route('admin.tags.index')
                         ->with('success', 'تم تحديث الوسم بنجاح.');
    }

    /**
     * حذف وسم من قاعدة البيانات.
     */
    public function destroy(Tag $tag)
    {
        // عند الحذف، لارافل سيقوم تلقائيًا بحذف العلاقات من الجدول الوسيط car_tags
        $tag->delete();

        return redirect()->route('admin.tags.index')
                         ->with('success', 'تم حذف الوسم بنجاح.');
    }
}