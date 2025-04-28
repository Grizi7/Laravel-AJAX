<div class="container mt-5">
    <h1>Categories</h1>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Parent</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <th scope="row">{{ $category->id }}</th>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                <td>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    {{ $categories->links('vendor.pagination.bootstrap-5') }} <!-- Pagination links -->
                </td>
            </tr>
        </tfoot>
    </table>
</div>