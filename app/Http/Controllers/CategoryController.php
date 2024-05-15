<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo "index call ";
        $products = DB::table('products')->select('id', 'name', 'image', 'price');
        $results  = ($products->get());
        return view('shop', ['products' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo "index call create ";
        // $products = DB::table('products')->select('id', 'name', 'image', 'price');
        // $results  = ($products->get());
        // return view('shop', ['products' => $results]);
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);
        $blog = Category::create($request->all());
        return view('category.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo "index show call ";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        echo "index edit call ";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        echo "index edit call ";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        echo "index destroy call ";
    }
}
