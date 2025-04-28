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
    
    <div id="app">
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite('resources/js/app.js')
    <script>
        $(document).ready(function () {
            const app = document.getElementById('app');

            $.ajax({
                url: 'http://127.0.0.1:8000/api/categories', // API URL
                method: 'GET', // Request method
                success: function (response) {
                    console.log(response);
                    app.innerHTML = `${response}`
                },
                error: function () {
                    app.innerHTML(`<div class="alert alert-danger" role="alert">Error loading categories.</div>`);
                }
            });
        });
    </script>
</body>
</html>