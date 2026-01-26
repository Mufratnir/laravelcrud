<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->paginate(
            $request->only(['search', 'category_id', 'status']),
            $request->get('per_page', 10)
        );

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ]
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category?->name,
                'status' => $product->status,
                'thumbnail' => $product->thumbnail
                    ? url('storage/' . $product->thumbnail)
                    : null,

                'description' => $product->description,
            ]
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request->validated());

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

    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->productService->update($product, $request->validated());

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
        $this->productService->delete($product);

        return response()->json([
            'success' => true,
            'message' => 'Product deleted'
        ]);
    }
}