<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Products</title>
</head>
<body>
       <h2>Products</h2>
<a href="{{ route('products.create') }}">Add Product</a>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="mb-4 flex gap-2">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search product..."
        class="border px-3 py-2 rounded"
    />

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Search
    </button>
</form>
<table border="1" cellpadding="8">
<tr>
    <th>Name</th>
    <th>Category</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>

@foreach($products as $product)
<tr>
    <td>{{ $product->name }}</td>
    <td>{{ $product->category->name }}</td>
    <td>
        @if($product->thumbnail)
        <img src="{{ asset('storage/'.$product->thumbnail) }}" width="60">
        @endif
    </td>
    <td>{{ $product->status ? 'Active':'Inactive' }}</td>
    <td>
        <a href="{{ route('products.edit',$product->id) }}">Edit</a>
        <form method="POST" action="{{ route('products.destroy',$product->id) }}" style="display:inline">
            @csrf @method('DELETE')
            <button>Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
</body>
</html>