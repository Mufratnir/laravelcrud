<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            10
        );

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store($request->validated());

        return redirect()->route('products.index')
                         ->with('success','Product created');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status',1)->get();
        return view('products.edit', compact('product','categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        return redirect()->route('products.index')
                         ->with('success','Product updated');
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()->route('products.index')
                         ->with('success','Product deleted');
    }
}