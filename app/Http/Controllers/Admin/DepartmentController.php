<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('translations')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20);

        return view('admin.pages.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.pages.departments.create');
    }

    public function store(DepartmentRequest $request)
    {
        $department = Department::create([
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        $locale = app()->getLocale();

        $department->setT('name', $locale, $request->name);

        if ($request->filled('description')) {
            $department->setT('description', $locale, $request->description);
        }

        return redirect()->route('admin.departments.index')
            ->with('success', __('general.created_successfully'));
    }

    public function edit(Department $department)
    {
        $department->load('translations');

        return view('admin.pages.departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update([
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        $locale = app()->getLocale();

        $department->setT('name', $locale, $request->name);

        if ($request->filled('description')) {
            $department->setT('description', $locale, $request->description);
        } else {
            $department->translations()
                ->where('field', 'description')
                ->where('locale', $locale)
                ->delete();
        }

        return redirect()->route('admin.departments.index')
            ->with('success', __('general.updated_successfully'));
    }

    public function destroy(Department $department)
    {
        $department->forgetTranslations();
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', __('general.deleted_successfully'));
    }
}
