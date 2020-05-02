<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount(['posts'])->paginate(10);
        $title = "Categories Management";
        return view('admin.categories.index',compact('categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Category";
        return view('admin.categories.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique|max:191|min:3',
            'description' => 'nullable|string',
        ]);
        
        // Переданные данные не прошли проверку
        if ($validator->fails()) {
            return redirect('admin/categories/create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('name', 'Something is wrong with this field!');
            }
        });
 
        Category::create($request->all());
        return redirect(route('admin.categories.index'))->withSuccess('Category Created Successfully');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.categories.show')->withCategory($category)->withTitle('Show Category');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit')->withCategory($category)->withTitle('Edit Category');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:191|min:3',
            'description' => 'nullable|string',
        ])->validate();
        
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->withSuccess('Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->withSuccess('Category Deleted Successfully');
    }

    // trashed
    public function trashed()
    {
        $categories = Category::onlyTrashed()->paginate();
        $title = 'Trashed Categories';
        return view('admin.categories.trashed', compact('title', 'categories'));
    }

    public function restore($id)
    {
        Category::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect(route('admin.categories.trashed'));
    }

    public function categoryDestroy($id)
    {
        $category = Category::withTrashed()
                ->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.categories.index');
    }

    public function force($id)
    {
        $category = Category::withTrashed()->where('id', $id)->first();  
        $category->forceDelete();
        return redirect()->route('admin.categories.index');
    }

}
