<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $fliterCategorySlug = $request->get('category');
        $categories = Category::take(11)->get();
        $category = Category::where('slug', $fliterCategorySlug)->first();
        if($category){
            $products = $category->products()->get();
        } else {
            $products = Product::all();
        }
        
        
        return view('products.list',[
            'products' => $products,
            'categories' => $categories
        ]
    );

    }
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        // dd($product->categories->toArray);
        $categories = Category::limit(11)->get();
        
        return view('products.show',[
            'product' => $product,
            'categories' => $categories
        ]
    );
    }
}
