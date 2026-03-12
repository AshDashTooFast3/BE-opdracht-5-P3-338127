<?php

namespace App\Http\Controllers;

use App\Models\Allergeen;
use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $ProductModel;

    private $LeverancierModel;

    private $AllergeenModel;

    private $MagazijnModel;

    public function __construct()
    {
        $this->ProductModel = new Product;
        $this->LeverancierModel = new Leverancier;
        $this->AllergeenModel = new Allergeen;
        $this->MagazijnModel = new Magazijn;
    }

    public function index(Request $request)
    {
        // haal het gekozen allergeen uit de querystring
        // handmatig pagineren omdat we een stored procedure gebruiken

        $page = $request->query('page', 1);
        $perPage = 4;
        $offset = ($page - 1) * $perPage;

        // SP aanroepen
        $results = $this->ProductModel->pakAlleProducten($perPage, $offset);

        // Data
        $data = collect($results);

        // Totaal apart berekenen
        $total = DB::table('Product')->count();

        // Laravel paginator
        $paginator = new LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('producten.index', [
            'titel' => 'Overzicht producten',
            'producten' => $paginator,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'startDatum' => 'required|date',
            'eindDatum' => 'required|date|after_or_equal:startDatum',
        ]);

        $page = $request->query('page', 1);
        $perPage = 4;
        $offset = ($page - 1) * $perPage;

        $results = $this->ProductModel->pakProductenBijDatum(
            $validated['startDatum'],
            $validated['eindDatum'],
            $perPage,
            $offset
        );

        // Data
        $data = collect($results);

        // Totaal apart berekenen
        $total = DB::table('Product')->count();

        // Laravel paginator
        $paginator = new LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('producten.index', [
            'titel' => 'Overzicht producten',
            'startDatum' => $request->input('startDatum'),
            'eindDatum' => $request->input('eindDatum'),
            'producten' => $paginator,
        ]);
    }

    public function Specifiek(Request $request, int $id)
    {
        $resultaten = null;

        if ($request->filled(['startDatum', 'eindDatum'])) {
            $resultaten = $this->ProductModel->pakProductBijId(
                $id,
                $request->input('startDatum'),
                $request->input('eindDatum')
            );
        }

        return view('producten.specifiek', [
            'titel' => 'Specificatie geleverde producten',
            'productId' => $id,
            'resultaten' => $resultaten,
        ]);
    }
}
