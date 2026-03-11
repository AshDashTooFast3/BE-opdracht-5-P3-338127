USE opdracht_5;

DROP PROCEDURE IF EXISTS pakProductBijId;

DELIMITER $$

CREATE PROCEDURE pakProductBijId(
    IN p_productId INT
)
BEGIN
    SELECT DISTINCT
        PROD.Id AS ProductId,
        LEV.Naam AS LeverancierNaam,
        LEV.Contactpersoon,
        PROD.Naam AS ProductNaam,
        MAG.AantalAanwezig