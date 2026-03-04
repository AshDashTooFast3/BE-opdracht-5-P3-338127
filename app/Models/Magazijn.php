<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    protected $table = 'Magazijn';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'VerpakkingsEenheid',
        'AantalAanwezig',
        'IsActief',
        'Opmerkingen',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
