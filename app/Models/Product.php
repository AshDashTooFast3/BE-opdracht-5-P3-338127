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

    public function pakAlleProducten()
    {
        return DB::select('CALL pakAlleProducten()');
    }
}
