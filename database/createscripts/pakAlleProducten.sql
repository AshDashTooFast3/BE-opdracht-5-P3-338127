USE opdracht_5;

DROP PROCEDURE IF EXISTS pakAlleProducten;

DELIMITER $$

CREATE PROCEDURE pakAlleProducten()
BEGIN
    SELECT DISTINCT
        LEV.Naam AS LeverancierNaam,
        LEV.Contactpersoon,
        PROD.Naam,
        MAG.AantalAanwezig
    FROM Product PROD
    INNER JOIN Magazijn MAG ON PROD.ID = MAG.ProductId
    INNER JOIN ProductPerLeverancier PPL ON PPL.ProductId = PROD.Id
    INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id;
END $$

DELIMITER ;

CALL pakAlleProducten();