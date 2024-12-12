<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $title = 'Главная';
        $allProducts = Product::all();
        $products = Product::where('hit', '>', 0)->orWhere('sale', '>', 0)->orWhere('old_price', '>', 0)->orderBy('title')->take(8)->get();
        return view('products.index', compact('title', 'products', 'allProducts'));
    }

    public function indexAdmin()
    {
        $products = Product::orderBy('category_id')->with('category')->paginate(15);
        $categories = Category::all();
        $orders = Order::all();
        return view('admin.index', compact('products', 'categories', 'orders'));
    }

    function update(Request $request, Product $product)
    {
        $product = Product::find($request->id);
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|integer',
            'status_id' => 'required|integer',
            'img' => 'image|nullable',
            'price' => 'required|integer',
            'old_price' => 'nullable|integer',
            'hit' => 'required|integer|max:1|min:0',
            'sale' => 'required|integer|max:1|min:0',
        ]);
        $product->update($request->all());

        //   // При выводе файла на странице нудно будет прибавить в начале "storage/"
        //   $fileNameToStore . "storage/";
        if ($request->hasFile('img')) {
            // Имя и расширение файла
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            // Только оригинальное имя файла
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Расширение
            $extention = $request->file('img')->getClientOriginalExtension();
            // Путь для сохранения
            $fileNameToStore = "img/" . $filename . "_" . time() . "." . $extention;
            // Сохраняем файл
            $path = $request->file('img')->storeAs('public/', $fileNameToStore);

            $product->img = $fileNameToStore;
            $product->save();
        }
      return redirect()->back()->with('success', 'Продукт обновлён');
    }

    public function create() {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|integer',
            'status_id' => 'required|integer',
            'img' => 'image|nullable',
            'price' => 'required|integer',
            'old_price' => 'nullable|integer',
            'hit' => 'required|integer|max:1|min:0',
            'sale' => 'required|integer|max:1|min:0',
        ]);
        $product = Product::create($request->all());
        if ($request->hasFile('img')) {
            // Имя и расширение файла
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            // Только оригинальное имя файла
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Расширение
            $extention = $request->file('img')->getClientOriginalExtension();
            // Путь для сохранения
            $fileNameToStore = "img/" . $filename . "_" . time() . "." . $extention;
            // Сохраняем файл
            $path = $request->file('img')->storeAs('public/', $fileNameToStore);
            $product->img = $fileNameToStore;
        }
        // dd($request->all());
        $product->save();
        return redirect('/admin')->with('success', 'Продукт создан');
    }

    public function destroy(Product $product)
    {  
        $product->delete();
        return redirect()->back()->with('success', 'Продукт удален');
    }

    public function show($slug)
    {
        $product = Product::query()->with(['category', 'status'])->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
