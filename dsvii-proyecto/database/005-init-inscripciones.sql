USE dsvii_final;

INSERT INTO inscripciones (usuario_id, taller_id)
SELECT u.id, t.id
FROM usuarios u, talleres t
WHERE u.username = 'testuser001' AND t.titulo = 'Seminario de Ciberseguridad en la Nube';

INSERT INTO inscripciones (usuario_id, taller_id)
SELECT u.id, t.id
FROM usuarios u, talleres t
WHERE u.username = 'testuser001' AND t.titulo = 'Conferencia de Inteligencia Artificial';

INSERT INTO inscripciones (usuario_id, taller_id)
SELECT u.id, t.id
FROM usuarios u, talleres t
WHERE u.username = 'testuser001' AND t.titulo = 'Curso de Contabilidad para Emprendedores';