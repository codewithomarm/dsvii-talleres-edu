DELIMITER $$

CREATE PROCEDURE inscripciones_por_usuario(IN nombre_usuario VARCHAR(50))
BEGIN
  SELECT 
    i.id AS inscripcion_id,
    i.fecha_inscripcion,
    t.id AS taller_id,
    t.titulo,
    t.descripcion,
    t.cupo_maximo,
    t.fecha_inicio,
    t.hora_inicio,
    t.fecha_fin,
    t.hora_fin
  FROM inscripciones i
  JOIN talleres t ON i.taller_id = t.id
  JOIN usuarios u ON i.usuario_id = u.id
  WHERE u.username = nombre_usuario;
END $$

DELIMITER ;