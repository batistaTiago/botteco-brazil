<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => Product::all(),
        ]);
    }

    public function store(CreateProductRequest $request)
    {
        $data = Product::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(UpdateProductRequest $request)
    {
        $product = Product::find($request->product_id);

        $product->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function delete(Request $request)
    {
        Product::where('id', $request->product_id)->delete();

        return response()->json([
            'success' => true
        ], 200);
    }
}
