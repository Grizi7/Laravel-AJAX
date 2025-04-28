<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories</title>
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div id="app" class="container mt-5">
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite('resources/js/app.js')
    <script>
        
        const app = document.getElementById('app');
        const modal = document.getElementsByClassName('modal-body');

        function fetchData(url, method = 'GET', onSuccess, onError) {
            $.ajax({
                url: url,
                method: method,
                success: onSuccess,
                error: onError
            });
        }

        function loadCategories(url = 'http://127.0.0.1:8000/api/categories') {
            fetchData(url, 'GET',
                function (response) {
                    app.innerHTML = response;
                },
                function () {
                    app.innerHTML = `<div class="alert alert-danger" role="alert">Error loading categories.</div>`;
                }
            );
        }

        $(document).ready(function () {
            fetchData(
                'http://127.0.0.1:8000/api/categories',
                'GET',
                function(response) {
                    app.innerHTML = `${response}`;
                },
                function() {
                    app.innerHTML = `<div class="alert alert-danger" role="alert">Error loading categories.</div>`;
                }
            );
        });

        $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                const url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (response) {
                        app.innerHTML = `${response}`;
                    },
                    error: function () {
                        app.innerHTML = `<div class="alert alert-danger" role="alert">Error loading categories.</div>`;
                    }
                });
            }
        );
        $(document).on('click', '.add-category', function (e) {
                $.ajax({
                    url: 'http://127.0.1:8000/api/categories/create', // API URL
                    method: 'GET', // Request method
                    success: function (response) {
                        $('.modal-body').html(response);
                    },
                    error: function () {
                        $('.modal-body').html(`<div class="alert alert-danger" role="alert">Error loading Form.</div>`);
                    }
                });
            }
        );

        $(document).on('click', '.search-btn', function () {
            let search = $('input[name="search"]').val(); // Get the search input value
            let parent_id = $('select[name="parent_id"]').val(); // Get the parent_id value

            $.ajax({
                url: `http://127.0.0.1:8000/api/categories?search=${search}&parent_id=${parent_id}`, // Use the form's action URL
                type: 'GET',
                success: function(response) {
                    // Handle success (e.g., close modal, refresh categories list)
                    app.innerHTML = response;
                },
                error: function(xhr) {
                    // Handle error (e.g., show validation errors)
                    app.innerHTML = `<div class="alert alert-danger" role="alert">Error loading categories.</div>`;
                }
            });
        });


        $(document).on('click', '.edit-btn', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    $('.modal-body').html(response);
                },
                error: function () {
                    $('.modal-body').html(`<div class="alert alert-danger" role="alert">Error loading Form.</div>`);
                }
            });
        });

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function (response) {
                    alert('Category deleted successfully!');
                    loadCategories('http://127.0.0.1:8000/api/categories');
                },
                error: function () {
                    app.innerHTML = `<div class="alert alert-danger" role="alert">Error loading categories.</div>`;
                }
            });
        });
    </script>
</body>
</html>