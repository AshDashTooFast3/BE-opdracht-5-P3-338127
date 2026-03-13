USE opdracht_5;

DROP PROCEDURE IF EXISTS pakProductInfo;

DELIMITER $$

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
END$$

DELIMITER ;

CALL pakProductInfo(1);