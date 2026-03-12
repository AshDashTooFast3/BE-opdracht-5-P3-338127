USE opdracht_5
;
DROP PROCEDURE IF EXISTS pakProductenBijDatum;

DELIMITER $$

CREATE PROCEDURE pakProductenBijDatum(
    IN Startdatum DATE,
    IN Einddatum DATE
)
BEGIN
    SELECT 
        PROD.Id,
        PROD.Naam,
        PROD.Barcode,
        PROD.DatumAangemaakt,
        PPL.DatumLevering
    FROM Product PROD
    INNER JOIN ProductPerLeverancier PPL ON PROD.Id = PPL.ProductId
    WHERE PPL.DatumLevering BETWEEN Startdatum AND Einddatum
    ORDER BY Naam;
END$$

DELIMITER ;

CALL pakProductenBijDatum('2023-01-01', '2023-04-19');