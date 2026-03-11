USE opdracht_5;

DROP PROCEDURE IF EXISTS pakAlleProducten;

DELIMITER $$

CREATE PROCEDURE pakAlleProducten(
    IN p_perPage INT,
    IN p_offset INT
)
BEGIN
    SELECT DISTINCT
        PROD.Id AS ProductId,
        LEV.Naam AS LeverancierNaam,
        LEV.Contactpersoon,
        PROD.Naam AS ProductNaam,
        MAG.AantalAanwezig
    FROM Product PROD
    INNER JOIN Magazijn MAG ON PROD.ID = MAG.ProductId
    INNER JOIN ProductPerLeverancier PPL ON PPL.ProductId = PROD.Id
    INNER JOIN Leverancier LEV ON PPL.LeverancierId = LEV.Id
    LIMIT p_perPage OFFSET p_offset;
END $$

DELIMITER ;

CALL pakAlleProducten(4, 0);