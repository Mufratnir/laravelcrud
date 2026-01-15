<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>categories</title>
</head>
<body>
        <h2>categories</h2>

        <a href="{{ route('categories.create') }}"> Add Category</a>
        @if(session('success'))
          <p>{{ session('success') }}</p>
        @endif
        <table border="1" cellpadding="8">
                <tr>
                     <th>Name</th>
                     <th>Status</th>
                     <th>Action</th>   
                </tr>
                @foreach ($categories as $category)
                <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->status ? 'Active': 'Inactive' }}</td>
                        <td>
                                <a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                </form>
                        </td>
                </tr>
                        
                @endforeach

        </table>
</body>
</html>