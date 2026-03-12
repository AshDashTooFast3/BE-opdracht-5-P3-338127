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

        // Haal de allergenen op voor de filter
        $allergenen = $this->AllergeenModel->all();

        // Filter op datums als deze zijn meegegeven
        if ($request->filled(['startDatum', 'eindDatum'])) {
            $results = $this->ProductModel->pakProductenBijDatum(
                $request->input('startDatum'),
                $request->input('eindDatum'),
                $perPage,
                $offset
            );
            $data = collect($results);
            $total = DB::table('Product')->whereBetween('created_at', [
                $request->input('startDatum'),
                $request->input('eindDatum'),
            ])->count();
            $paginator = new LengthAwarePaginator(
                $data,
                $total,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('producten.index', [
            'titel' => 'Overzicht producten',
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
