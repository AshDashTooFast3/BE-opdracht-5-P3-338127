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

    public function Specifiek() {

    
        return view('producten.specifiek', [
            'titel' => 'Specificatie geleverde producten',
        ]);
    }
}
