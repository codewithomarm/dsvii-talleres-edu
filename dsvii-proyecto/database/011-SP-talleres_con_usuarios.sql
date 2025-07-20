DELIMITER $$

CREATE PROCEDURE talleres_con_usuarios()
BEGIN
  SELECT
    t.id AS workshop_id,
    t.titulo,
    t.descripcion,
    u.id AS user_id,
    u.nombre,
    u.username,
    u.email
  FROM talleres t
  LEFT JOIN inscripciones i ON t.id = i.taller_id
  LEFT JOIN usuarios u ON i.usuario_id = u.id
  ORDER BY t.id, u.id;
END $$

DELIMITER ;
