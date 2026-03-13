USE opdracht_5;

DROP PROCEDURE IF EXISTS pakAlleProducten;

DELIMITER $$

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
END $$

DELIMITER ;

CALL pakAlleProducten(4, 0);