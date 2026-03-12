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
        <div class="col-md-10">
            <h1>{{ $titel }}</h1>
            <form method="GET" action="{{ route('producten.store') }}" class="mb-4">
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
                <button type="submit" class="btn btn-primary mt-3">Maak selectie</button>
            </form>
            <hr class="my-4" />

            {{-- Producten tabel --}}
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Naam Product</th>
                        <th>Naam Allergeen</th>
                        <th>Omschrijving</th>
                        <th>Aantal Aanwezig</th>
                        <th class="text-center">Info</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($producten as $product)
                        <tr>
                            <td>{{ $product->LeverancierNaam }}</td>
                            <td>{{ $product->Contactpersoon }}</td>
                            <td>{{ $product->ProductNaam }}</td>

                            <td
                                class="{{ $product->AantalAanwezig == 0 || $product->AantalAanwezig === null ? 'text-danger' : 'text-success' }}">
                                {{ $product->AantalAanwezig ?? 0 }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('producten.specifiek', $product->ProductId) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-info-circle-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Geen producten bekend</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Paginatie -->
                <div class="mt-3">
                    {{ $producten->links('pagination::bootstrap-4') }}
                </div>
                <a href="{{ route('welcome') }}" class="btn btn-secondary">
                    Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>