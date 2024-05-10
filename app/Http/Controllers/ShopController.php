<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function shopview(Request $request)
    {
        $products = DB::table('products')->select('id', 'name', 'image', 'price');
        $results  = ($products->get());
        return view('shop', ['products' => $results]);
    }
    public function shopchitiet(Request $request, $id)
    {
        // $products = DB::table('products')->select('id', 'name', 'image', 'price');
        // $results  = ($products->get());
        return view('shopchitiet');
    }
}
