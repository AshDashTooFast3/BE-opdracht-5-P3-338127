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
                    @forelse ($ProductVanEenAllergeen as $product)
                        <tr>
                            <td>{{ $product->ProductNaam }}</td>
                            <td>{{ $product->AllergeenNaam }}</td>
                            <td>{{ $product->Omschrijving }}</td>

                            <td class="{{ $product->AantalAanwezig == 0 ? 'text-danger' : 'text-success' }}">
                                {{ $product->AantalAanwezig ?? 0 }}
                            </td>

                            {{-- <td class="text-center">
                                <a href="{{ route('leveranciers.index', $product->LeverancierId) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-info-circle-fill"></i>
                                </a>
                            </td> --}}
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
                {{-- <div class="mt-3">
                    {{ $ProductVanEenAllergeen->links('pagination::bootstrap-5') }}
                </div> --}}
                <a href="{{ route('welcome') }}" class="btn btn-secondary">
                    Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>