<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Homepagina</title>
</head>

<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
    </style>
    <div class="container" style="max-width: 200px;">
        <div class="border-bottom pb-3 mb-4 d-inline-block">
            <h1 class="h4 fw-normal">Homepagina
                <hr>
            </h1>
        </div>
        <a href="{{ route('producten.index') }}" class="border-bottom text-decoration-none text-dark d-inline-block"
            style="font-size: 20px;">
            Overzicht producten
        </a>
    </div>
</body>

</html>