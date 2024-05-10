<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function productview(Request $request)
    {
        $products = DB::table('products')->select('id', 'name', 'image', 'price');
        $results  = ($products->get());
        return view('product', ['products' => $results]);
    }

    public function productdetail(Request $request)
    {
        $id = $request->id;
        $products = DB::table('products')->select('id', 'name', 'image', 'price')->where('id', '=', $id);
        $results  = ($products->get());
        return view('product', ['products' => $results]);
    }
    public function productSearch(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        // Perform the query using Eloquent
        $products = DB::table('products')->select('id', 'name', 'image', 'price')
            ->where('name', 'like', '%' . $validated['keyword'] . '%')
            ->get();

        // Pass the products to the view
        return view('product', ['products' => $products]);
    }
}