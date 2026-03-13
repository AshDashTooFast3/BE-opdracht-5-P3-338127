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
  SELECT DISTINCT
    PROD.Id AS ProductId,
    PROD.Naam AS ProductNaam,
    PROD.Barcode,
    MIN(PPL.DatumAangemaakt) AS DatumAangemaakt,
    MIN(PPL.DatumLevering) AS DatumLevering,
    MIN(LEV.Naam) AS LeverancierNaam,
    MIN(LEV.Contactpersoon) AS Contactpersoon,
    MAX(MAG.AantalAanwezig) AS AantalAanwezig
FROM Product PROD
INNER JOIN ProductPerLeverancier PPL ON PROD.Id = PPL.ProductId
INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id
INNER JOIN Magazijn MAG ON PROD.Id = MAG.ProductId
WHERE PPL.DatumLevering BETWEEN Startdatum AND Einddatum
GROUP BY PROD.Id, PROD.Naam, PROD.Barcode
ORDER BY PROD.Naam
LIMIT p_perPage OFFSET p_offset;
END$$

DELIMITER ;

CALL pakProductenBijDatum('2023-01-01', '2023-12-31', 4, 0);
