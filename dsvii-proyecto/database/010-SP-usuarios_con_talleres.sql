DELIMITER $$

CREATE PROCEDURE usuarios_con_talleres()
BEGIN
  SELECT
    u.id AS user_id,
    u.nombre,
    u.username,
    u.email,
    t.id AS workshop_id,
    t.titulo,
    t.descripcion
  FROM usuarios u
  LEFT JOIN inscripciones i ON u.id = i.usuario_id
  LEFT JOIN talleres t ON i.taller_id = t.id
  ORDER BY u.id, t.id;
END $$

DELIMITER ;
