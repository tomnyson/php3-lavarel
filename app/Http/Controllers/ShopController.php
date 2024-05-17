<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all()->take(12);
        return view('shop', ['products' => $products]);
    }
    public function shopchitiet(Request $request, $id)
    {
        // $products = DB::table('products')->select('id', 'name', 'image', 'price');
        // $results  = ($products->get());
        return view('shopchitiet');
    }
}