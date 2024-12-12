<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // $category = Category::query()->where('slug', $slug)->firstOrFail();
        // $products = $category->products()->paginate(12);
        // return view('categories.show', compact('category', 'products'));

        $category = Category::where('slug', $slug)->firstOrFail();
        $sort = request('sort');
    
        $query = $category->products();
    
        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort == 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sort == 'title_desc') {
            $query->orderBy('title', 'desc');
        }
    
        $products = $query->paginate(8);
    
        return view('categories.show', compact('category', 'products'));
    }

    public function createCategory()
    {
        return view('admin.createCategory');
    }

    public function storeCategory(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $category = Category::create($request->all());
        $category->save();

        return redirect('/admin')->with('success', 'Категория добавлена');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        $request->validate([
            'title' => 'required|unique:categories'
        ]);
        $category->update($request->all());
        $category->save();
        return redirect('/admin')->with('success', 'Категория была обновлена');
    }

    public function destroyCategory ($id)
    {
        Category::where('id', $id)->delete();
        return redirect('/admin')->with('success', 'Категория была удалена');
    }
}
