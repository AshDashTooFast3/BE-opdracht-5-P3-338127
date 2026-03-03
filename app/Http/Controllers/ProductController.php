<?php

namespace App\Http\Controllers;

use App\Models\Allergeen;
use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;

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

    public function index()
    {

        return view('producten.index', [
            'title' => 'Overzicht producten',
        ]);
    }
}
