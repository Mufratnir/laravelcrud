<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Product</title>
</head>
<body>
        <h2>Edit Product</h2>
        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ $product->name }}"><br><br>

                <select name="category_id">
                        @foreach (@$categories as  $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>                                
                        @endforeach
                </select><br><br>

                @if($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" width="80"><br>
                @endif
                <input type="file" name="thumbnail"><br><br>

                <select name="status">
                <option value="1" {{ $product->status ? 'selected':'' }}>Active</option>
                <option value="0" {{ !$product->status ? 'selected':'' }}>Inactive</option>
                </select><br><br>

                <button>Update</button>
        </form>
</body>
</html>