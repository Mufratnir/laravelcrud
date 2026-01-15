<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
</head>
<body>
        <h2>Create Product</h2>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Product Name"><br><br>

                <select name="category_id">
                        @foreach (@$categories as  $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>                                
                        @endforeach
                </select><br><br>
                <input type="file" name="thumbnail"><br><br>
                <select name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                </select><br><br>

                <button type="submit">Create</button>
        </form>
</body>
</html>