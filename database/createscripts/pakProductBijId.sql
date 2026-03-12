USE opdracht_5;

DROP PROCEDURE IF EXISTS pakProductBijId;

DELIMITER $$

CREATE PROCEDURE pakProductBijId(
    IN p_productId INT
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
END$$

DELIMITER ;

CALL pakProductBijId(1);