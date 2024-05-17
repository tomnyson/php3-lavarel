<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo "index call create ";
        // $categories = DB::table('category')->select('id', 'name', 'description');
        $categories = Category::all();
        // $results  = ($categories->get());
        return view('category.list', ['categories' => $categories]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo "index call create ";
        $categories = DB::table('category')->select('id', 'name');
        $results  = ($categories->get());
        return view('category.create', ['category' => $results]);
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
        return redirect()->route('categories.index')->with('success', 'Thêm thành công');
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
        echo "index call ";
        $categories = Category::where('id', $id);
        $results  = ($categories->get());
        return view('category.edit', ['category' => $results[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated =  $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);
        var_dump($request->all());

        $updated = [
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ];
        $blog = Category::where('id', $id)->update($updated);
        return redirect()->route('categories.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('category')->where('id', $id)->delete();
        return redirect()->route('categories.index')->with('success', 'delete successfully');
    }
}
