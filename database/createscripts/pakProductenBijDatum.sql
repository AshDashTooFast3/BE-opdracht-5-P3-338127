USE opdracht_5;

DROP PROCEDURE IF EXISTS pakProductenBijDatum;

DELIMITER $$
CREATE PROCEDURE pakProductenBijDatum(
    IN Startdatum DATE,
    IN Einddatum DATE,
    IN p_perPage INT,
    IN p_offset INT
)
BEGIN
    SELECT 
        PROD.Id AS ProductId,
        PROD.Naam AS ProductNaam,
        PROD.Barcode,
        PPL.DatumAangemaakt,
        PPL.DatumLevering,
        LEV.Naam AS LeverancierNaam,
        LEV.Contactpersoon,
        MAG.AantalAanwezig
    FROM Product PROD
    INNER JOIN ProductPerLeverancier PPL ON PROD.Id = PPL.ProductId
    INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id
    INNER JOIN Magazijn MAG ON PROD.Id = MAG.ProductId
    WHERE PPL.DatumLevering BETWEEN Startdatum AND Einddatum
    ORDER BY PROD.Naam
    LIMIT p_perPage OFFSET p_offset;
END$$

DELIMITER ;

CALL pakProductenBijDatum('2023-01-01', '2023-12-31', 4, 0);