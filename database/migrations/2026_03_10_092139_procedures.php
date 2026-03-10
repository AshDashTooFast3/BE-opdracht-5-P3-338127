<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS pakAlleProducten;');
        DB::statement('
        CREATE PROCEDURE pakAlleProducten()
        BEGIN
            SELECT DISTINCT
                LEV.Naam AS LeverancierNaam,
                LEV.Contactpersoon,
                PROD.Naam AS ProductNaam,
                MAG.AantalAanwezig
            FROM Product PROD
            INNER JOIN Magazijn MAG ON PROD.ID = MAG.ProductId
            INNER JOIN ProductPerLeverancier PPL ON PPL.ProductId = PROD.Id
            INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
