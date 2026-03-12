<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titel }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="mt-4">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6">

            <h1 class="text-decoration-underline">{{ $titel }}</h1>

            {{-- Info blok --}}
            <div class="mt-3">
                <p><strong>Startdatum:</strong> {{ request('startDatum') }}</p>
                <p><strong>Einddatum:</strong> {{ request('eindDatum') }}</p>
                @forelse ($productinfo as $product)
                    <p><strong>Productnaam:</strong> {{ $product->Naam ?? 'Product niet gevonden' }}</p>
                    <p><strong>Allergenen:</strong> {{ $product->Allergenen ?? 'Geen allergeen bekend' }}</p>
                @empty
                    <p><strong>Productnaam:</strong> Product niet gevonden</p>
                    <p><strong>Allergenen:</strong> Geen allergeen bekend</p>
                @endforelse
            </div>

            <hr class="my-4" />

            {{-- Leveringen tabel --}}
            @if ($resultaten !== null && count($resultaten) > 0)
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Datum levering</th>
                            <th>Aantal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultaten as $rij)
                            <tr>
                                <td>{{ $rij->DatumLevering }}</td>
                                <td>{{ $rij->Aantal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Geen leveringen gevonden voor de opgegeven periode.</p>
            @endif

            <div class="mt-3">
                <a href="{{ route('producten.index') }}" class="btn btn-secondary">Terug naar overzicht</a>
            </div>

        </div>
    </div>
</body>

</html>