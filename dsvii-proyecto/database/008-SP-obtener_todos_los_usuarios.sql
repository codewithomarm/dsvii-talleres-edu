DELIMITER $$

CREATE PROCEDURE obtener_todos_los_usuarios()
BEGIN
  SELECT 
    id, nombre, username, email, is_admin, fecha_registro, cedula_id
  FROM usuarios;
END $$

DELIMITER ;