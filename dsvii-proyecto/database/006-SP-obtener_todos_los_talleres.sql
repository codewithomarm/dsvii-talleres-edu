DELIMITER $$

CREATE PROCEDURE obtener_todos_los_talleres()
BEGIN
  SELECT * FROM talleres;
END $$

DELIMITER ;