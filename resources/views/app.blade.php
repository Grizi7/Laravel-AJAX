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
                url,
                method,
                success: onSuccess,
                error: onError
            });
        }

        function showError(target, message = 'Error loading data.') {
            $(target).html(`<div class="alert alert-danger" role="alert">${message}</div>`);
        }

        function loadIntoApp(url) {
            fetchData(url, 'GET',
                response => app.innerHTML = response,
                () => showError(app, 'Error loading categories.')
            );
        }

        function loadIntoModal(url) {
            fetchData(url, 'GET',
                response => $('.modal-body').html(response),
                () => showError('.modal-body', 'Error loading form.')
            );
        }

        $(document).ready(function () {
            loadIntoApp('http://127.0.0.1:8000/api/categories');
        });

        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url) {
                loadIntoApp(url);
            }
        });

        $(document).on('click', '.add-category', function () {
            loadIntoModal('http://127.0.0.1:8000/api/categories/create');
        });

        $(document).on('click', '.edit-btn', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url) {
                loadIntoModal(url);
            }
        });

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url) {
                fetchData(url, 'DELETE',
                    () => {
                        alert('Category deleted successfully!');
                        loadIntoApp('http://127.0.0.1:8000/api/categories');
                    },
                    () => showError(app, 'Error deleting category.')
                );
            }
        });

        $(document).on('click', '.search-btn', function () {
            const search = $('input[name="search"]').val();
            const parent_id = $('select[name="parent_id"]').val();
            const url = `http://127.0.0.1:8000/api/categories?search=${encodeURIComponent(search)}&parent_id=${encodeURIComponent(parent_id)}`;

            loadIntoApp(url);
        });

    </script>
</body>
</html>