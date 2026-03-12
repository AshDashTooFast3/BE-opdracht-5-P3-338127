USE opdracht_5;

DROP PROCEDURE IF EXISTS pakProductBijId;

DELIMITER $$

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
        AND ppl.DatumLevering BETWEEN p_startDatum AND p_eindDatum
        AND p.IsActief = 1
        AND ppl.IsActief = 1;
END$$

DELIMITER ;