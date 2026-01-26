<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with('category');
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        return $query->paginate($perPage);
    }
    public function store(array $data)
    {
        $imagePath = null;

        if (isset($data['thumbnail'])) {
            $imagePath = $data['thumbnail']->store('products', 'public');
        }

        return Product::create([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'thumbnail'   => $imagePath,
            'category_id' => $data['category_id'],
            'status'      => $data['status'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['thumbnail'])) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $product->thumbnail = $data['thumbnail']->store('products', 'public');
        }

        $product->update([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'category_id' => $data['category_id'],
            'status'      => $data['status'],
            'description' => $data['description'] ?? null,
        ]);

        return $product;
    }

    public function delete(Product $product)
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        return $product->delete();
    }
}