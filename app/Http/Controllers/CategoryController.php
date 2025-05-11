<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
    
        $products = Product::where('category_id', $category->id)
            ->when(request('min_price'), function($query) {
                return $query->where('price', '>=', request('min_price'));
            })
            ->when(request('max_price'), function($query) {
                return $query->where('price', '<=', request('max_price'));
            })
            ->when(request('sort'), function($query) {
                switch (request('sort')) {
                    case 'price_asc':
                        return $query->orderBy('price', 'asc');
                    case 'price_desc':
                        return $query->orderBy('price', 'desc');
                    case 'title_asc':
                        return $query->orderBy('title', 'asc');
                    case 'title_desc':
                        return $query->orderBy('title', 'desc');
                    default:
                        return $query;
                }
            })
            ->paginate(9)
            ->appends(request()->query());
    
        $categories = Category::all();
    
        return view('categories.show', compact('category', 'products', 'categories'));
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
