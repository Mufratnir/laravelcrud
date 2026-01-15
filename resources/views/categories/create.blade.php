<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Create Category</title>
</head>
<body>
        <h2>Create Category</h2>

        <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <input type="text" name="name" placeholder="Category Name"><br><br>

                <select name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                </select><br><br>

                <button type="submit">Save</button>

        </form>
</body>
</html>