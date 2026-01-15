<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ProductApiController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'status' => $product->status,
                'thumbnail' => $product->thumbnail
                    ? url('storage/' . $product->thumbnail)
                    : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'status' => $product->status,
                'thumbnail' => $product->thumbnail
                    ? url('storage/' . $product->thumbnail)
                    : null,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image',
            'status' => 'required|boolean',
            'description'=>'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'thumbnail' => $imagePath,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'status' => $product->status,
                'thumbnail' => $product->thumbnail
                    ? url('storage/' . $product->thumbnail)
                    : null,
            ]
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'nullable|image',
            'status' => 'required|boolean',
            'description'=>'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $product->thumbnail = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'status' => $request->status,
            'description'=> $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'status' => $product->status,
                'thumbnail' => $product->thumbnail
                    ? url('storage/' . $product->thumbnail)
                    : null,
            ]
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted'
        ]);
    }
}