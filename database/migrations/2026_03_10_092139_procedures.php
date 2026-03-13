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
        DB::statement('DROP PROCEDURE IF EXISTS pakProductenBijDatum;');
        DB::statement('DROP PROCEDURE IF EXISTS pakProductBijId;');
        DB::statement('DROP PROCEDURE IF EXISTS pakProductInfo;');

        DB::statement('
        CREATE PROCEDURE pakAlleProducten(
            IN p_perPage INT,
            IN p_offset INT
        )
        BEGIN
            SELECT
            PROD.Id AS ProductId,
            LEV.Naam AS LeverancierNaam,
            LEV.Contactpersoon,
            PROD.Naam AS ProductNaam,
            SUM(PPL.Aantal) AS Aantal
            FROM Product PROD
            INNER JOIN (
            SELECT ProductId, MIN(LeverancierId) AS LeverancierId
            FROM ProductPerLeverancier
            GROUP BY ProductId
            ) PPL_MIN ON PPL_MIN.ProductId = PROD.Id
            INNER JOIN ProductPerLeverancier PPL ON PPL.ProductId = PROD.Id AND PPL.LeverancierId = PPL_MIN.LeverancierId
            INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id
            GROUP BY PROD.Id, LEV.Naam, LEV.Contactpersoon, PROD.Naam
            LIMIT p_perPage OFFSET p_offset;
        END
        ');
        DB::statement('
        CREATE PROCEDURE pakProductenBijDatum(
            IN Startdatum DATE,
            IN Einddatum DATE,
            IN p_perPage INT,
            IN p_offset INT
        )
        BEGIN
            SELECT DISTINCT
            PROD.Id AS ProductId,
            PROD.Naam AS ProductNaam,
            PROD.Barcode,
            MIN(PPL.DatumAangemaakt) AS DatumAangemaakt,
            MIN(PPL.DatumLevering) AS DatumLevering,
            MIN(LEV.Naam) AS LeverancierNaam,
            MIN(LEV.Contactpersoon) AS Contactpersoon,
            SUM(PPL.Aantal) AS Aantal
            FROM Product PROD
            INNER JOIN ProductPerLeverancier PPL ON PROD.Id = PPL.ProductId
            INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id
            INNER JOIN Magazijn MAG ON PROD.Id = MAG.ProductId
            WHERE PPL.DatumLevering BETWEEN Startdatum AND Einddatum
            GROUP BY PROD.Id, PROD.Naam, PROD.Barcode
            ORDER BY PROD.Naam
            LIMIT p_perPage OFFSET p_offset;
        END
        ');

        DB::statement('
        CREATE PROCEDURE pakProductBijId(
            IN p_productId INT,
            IN p_startDatum DATE,
            IN p_eindDatum DATE
        )
        BEGIN
            SELECT DISTINCT
                p.Id,
                p.Naam,
                p.Barcode,
                ppl.DatumLevering,
                ppl.Aantal,
                l.Naam AS LeverancierNaam
            FROM Product p
            LEFT JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
            LEFT JOIN Leverancier l ON ppl.LeverancierId = l.Id
            WHERE p.Id = p_productId
            AND (ppl.DatumLevering BETWEEN p_startDatum AND p_eindDatum OR p_startDatum IS NULL);
        END
    ');
        DB::statement('
        CREATE PROCEDURE pakProductInfo(
            IN p_id INT
        )
        BEGIN
            SELECT 
                p.Id,
                p.Naam,
                p.Barcode,
                GROUP_CONCAT(a.Naam SEPARATOR ", ") AS Allergenen
            FROM Product p
            LEFT JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
            LEFT JOIN Allergeen a ON ppa.AllergeenId = a.Id
            WHERE p.Id = p_id
            GROUP BY p.Id, p.Naam, p.Barcode;
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
