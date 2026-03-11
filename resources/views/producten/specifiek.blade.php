@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titel }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="mt-4">
    <div class="container d-flex justify-content-center">
        <div class="col-md-10">
            <h1>{{ $titel }}</h1>
            <hr class="my-4" />

            
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('welcome') }}" class="btn btn-secondary">
                    Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>