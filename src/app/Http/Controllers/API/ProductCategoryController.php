<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => ProductCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = ProductCategory::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $product_category = ProductCategory::find($request->product_category_id);

        $product_category->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $product_category
        ]);
    }

    public function delete(Request $request)
    {
        ProductCategory::where('id', $request->product_category_id)->delete();

        return response()->json([
            'success' => true
        ], 200);
    }
}
