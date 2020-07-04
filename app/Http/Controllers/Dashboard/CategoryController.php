<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories=Category::when($request->search, function ($query) use ($request) {
            return $query->whereTranslationLike('name',  '%' . $request->search . '%');
        })->latest()->paginate(5);;
        return view('dashboard.categories.index')->with('categories',$categories);
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $rules=[];
        foreach (config('translatable.locales') as $locale){
            $rules+=[$locale.'.name'=> ['required',Rule::unique('category_translations','name')]];
        }
        $request->validate($rules);
        Category::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }


    public function edit(Category $category)
    {
        return view('dashboard.categories.edit')->with('category',$category);
    }

    public function update(Request $request, Category $category)
    {
        $rules=[];
        foreach (config('translatable.locales') as $locale){
            $rules+=[$locale.'.name'=> ['required',Rule::unique('category_translations','name')->ignore($category->id,'category_id')]];
        }
        $request->validate($rules);

        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
