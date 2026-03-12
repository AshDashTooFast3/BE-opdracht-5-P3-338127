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

            <form method="GET" action="{{ route('producten.specifiek', $productId) }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="startDatum" class="form-label">Startdatum</label>
                        <input type="date" id="startDatum" name="startDatum" class="form-control"
                            value="{{ request('startDatum') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="eindDatum" class="form-label">Einddatum</label>
                        <input type="date" id="eindDatum" name="eindDatum" class="form-control"
                            value="{{ request('eindDatum') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Zoeken</button>
            </form>

            @if ($resultaten !== null)
                @if (count($resultaten) > 0)
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Productnaam</th>
                                <th>Barcode</th>
                                <th>Datum levering</th>
                                <th>Aantal</th>
                                <th>Leverancier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultaten as $rij)
                                <tr>
                                    <td>{{ $rij->Naam }}</td>
                                    <td>{{ $rij->Barcode }}</td>
                                    <td>{{ $rij->DatumLevering }}</td>
                                    <td>{{ $rij->Aantal }}</td>
                                    <td>{{ $rij->LeverancierNaam }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Geen leveringen gevonden voor de opgegeven periode.</p>
                @endif
            @endif

            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('producten.index') }}" class="btn btn-secondary">
                    Terug naar overzicht
                </a>
            </div>
        </div>
    </div>
</body>

</html>