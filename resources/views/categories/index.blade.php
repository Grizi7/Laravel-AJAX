<h1>Categories</h1>
<div class="row mb-4">
    <div class="col-md-8">
        <div class="row g-2">
            <!-- Search Input -->
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search categories" id="search-input" name="search" value="{{ request('search') }}">
                </div>
            </div>
            
            <!-- Parent Category Filter -->
            <div class="col-md-4">
                <select class="form-select" id="parent-filter" name="parent_id">
                    <option value="">All Categories</option>
                    @foreach ($categoriesInSelect as $category)
                        <option value="{{ $category->id }}" {{ request('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Clear Filters Button -->
            <div class="col-md-4">
                <button class="btn btn-secondary search-btn w-100">Filter</button>
            </div>

            <div class="col-md-4 ms-1">
                <button class="btn btn-danger delete-all-btn">Delete All</button>
            </div>
        </div>
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
        @if ($categories->isEmpty())
            <tr>
                <td colspan="4" class="text-center">No categories found.</td>
            </tr>
        @endif
        @foreach ($categories as $index => $category)
            <tr>
                <th scope="row"><input class="form-check-input me-1" type="checkbox" id="inlineCheckbox{{ $category->id }}" value="{{ $category->id }}">{{ (($currentPage-1) * $categories->perPage()) + $index+1 }}</th>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                <td>
                <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#categoryModel" data-url="{{ route('categories.edit', $category->id) }}">Edit</button>
                <button class="btn btn-danger delete-btn"  data-url="{{ route('categories.destroy', $category->id) }}">Delete</button>
                
                </td>
            </tr>
        @endforeach
    </tbody>
    @if (!$categories->isEmpty())
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
    @endif
</table>