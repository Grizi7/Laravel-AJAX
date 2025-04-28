<form action="{{ route('categories.store') }}" method="POST" class="add-form">
    @csrf
    <div class="errors">

    </div>
    <!-- Name Field -->
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    
    <!-- Parent Category Selection -->
    <div class="mb-3">
        <label for="parent_id" class="form-label">Parent Category</label>
        <select class="form-select" id="parent_id" name="parent_id">
            <option value="">None (Top Level Category)</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <!-- Form Actions -->
    <div class="d-flex gap-2 float-end">
        <button type="submit" class="btn btn-primary">Create Category</button>
    </div>
</form>

<script>
    $('.add-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: $(this).attr('action'), // Use the form's action URL
            type: 'POST',
            data: $(this).serialize(), // Serialize the form data
            success: function(response) {
                // Handle success (e.g., close modal, refresh categories list)
                $('.modal-body').html('<div class="alert alert-success" role="alert">Category created successfully!</div>');
                // Wait 1.5 seconds then close the modal and refresh the page
                
                $('#categoryModel').modal('hide');
                
                modal.innerHTML = ''; // Clear the modal content
                loadIntoApp('http://127.0.0.1:8000/api/categories');
            },
            error: function(xhr) {
                // Handle error (e.g., show validation errors)
                const errors = xhr.responseJSON.errors;
                $('.errors').empty(); // Clear previous errors
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        const errorMessage = errors[key][0]; // Get the first error message for the field
                        $('.errors').append('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
                    }
                }
            }
        });
    });
</script>