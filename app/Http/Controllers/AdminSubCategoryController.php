<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Size;
use App\Models\Product;
use App\Models\ProductSize;

class AdminSubCategoryController extends Controller
{
    public function index()
    {
        // Complete it
        return view("dashboard.subcategories.index", []);
    }

    public function create()
    {
        return view("dashboard.subcategories.create", [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
            'sizes' => Size::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => ["required", "min:2", "max:255"],
                'description' => ["required", "min:2"],
                'category' => ["required"],
                'sizes' => ["required", "array"],
                'quantities' => ["required", "array"],
                'price' => ["required", "integer"],
            ],
        );

        $subcategory_id = $request->category;
        $category_id = SubCategory::where("id", $subcategory_id)->first()->category_id;

        $product = Product::create([
            "category_id" => $category_id,
            "subcategory_id" => $subcategory_id,
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
        ]);

        $sizes = $request->sizes;
        $quantities = $request->quantities;

        foreach ($sizes as $size => $value) {
            ProductSize::create([
                "product_id" => $product->id,
                "size_id" => $value,
                "quantity" => $quantities[$size],
            ]);
        }

        session()->flash('success', 'Product added successfully!');

        return redirect('/');
    }

    public function edit(SubCategory $subcategory)
    {
        // Complete it
        return view("dashboard.subcategories.edit", [
            'subcategory' => $subcategory,
        ]);
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        // Complete it
    }

    public function destroy(SubCategory $subcategory)
    {
        // Complete it
    }
}
