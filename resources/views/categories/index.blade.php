<h1>Categories</h1>
<div class="row mb-4">
    <div class="col-md-8">
        <form class="row g-3" action="{{ route('categories.index') }}" method="GET">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search categories" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="parent_id" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="null" {{ request('parent_id') === 'null' ? 'selected' : '' }}>Top Level Only</option>
                    @foreach ($categoriesInSelect as $category)
                        <option value="{{ $category->id }}" {{ request('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="reset" class="btn btn-secondary" onclick="window.location='{{ route('categories.index') }}'">Clear Filters</button>
            </div>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-success add-category" data-bs-toggle="modal" data-bs-target="#categoryModel" >
            <i class="bi bi-plus-circle"></i> Create Category
        </button>
    </div>
</div>
<div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="categoryModelLabel">Category Model</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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