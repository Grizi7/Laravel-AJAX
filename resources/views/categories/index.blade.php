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
            @foreach ($categories as $index => $category)
                <tr>
                    <th scope="row">{{ (($currentPage-1) * $categories->perPage()) + $index+1 }}</th>
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @foreach ( $pagination as $page )
                                @if ($page['url'] == null)
                                    @continue
                                @endif                            
                                <li class="page-item"><a class="page-link {{ $currentPage == $page['label'] ? 'active' : '' }}" href="#" data-url="{{ $page['url'] }}" >{{ $page['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                </td>
            </tr>
        </tfoot>
    </table>
</div>