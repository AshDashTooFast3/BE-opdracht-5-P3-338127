<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'Product';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Barcode',
        'IsActief',
        'Opmerkingen',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    public function magazijnen()
    {
        return $this->hasMany(Magazijn::class, 'ProductId');
    }

    public function pakAlleProducten(int $perPage, int $offset )
    {
        return DB::select('CALL pakAlleProducten(?, ?)', [$perPage, $offset]);
    }

    public function pakProductBijId(int $productId, string $startDatum, string $eindDatum)
    {
        return DB::select('CALL pakProductBijId(?, ?, ?)', [$productId, $startDatum, $eindDatum]);
    }
}
