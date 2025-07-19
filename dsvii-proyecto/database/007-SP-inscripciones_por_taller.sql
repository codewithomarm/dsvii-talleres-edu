DELIMITER $$

CREATE PROCEDURE inscripciones_por_taller(IN titulo_taller VARCHAR(100))
BEGIN
  SELECT 
    i.id AS inscripcion_id,
    i.fecha_inscripcion,
    u.id AS usuario_id,
    u.nombre,
    u.username,
    u.email,
    u.is_admin,
    u.fecha_registro
  FROM inscripciones i
  JOIN usuarios u ON i.usuario_id = u.id
  JOIN talleres t ON i.taller_id = t.id
  WHERE t.titulo = titulo_taller;
END $$

DELIMITER ;