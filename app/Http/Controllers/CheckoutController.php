<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::content();
        return view('checkout.index', compact('carts'));
    }
}
