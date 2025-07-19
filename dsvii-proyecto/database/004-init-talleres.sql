-- Asegúrate de estar usando la base de datos correcta
USE dsvii_final;

INSERT INTO talleres (
  titulo, descripcion, cupo_maximo, fecha_inicio, hora_inicio, fecha_fin, hora_fin
) VALUES 
(
  'Seminario de Ciberseguridad en la Nube',
  'Seminario para aprender como aplicar metodos de ciberseguirdad en proyectos Cloud',
  50,
  '2025-10-08', '17:00:00',
  '2025-10-08', '21:00:00'
),
(
  'Conferencia de Inteligencia Artificial',
  'Conferencia inductiva y educativa para que aprendas las implementaciones de la IA en proyectos de software y servicios diarios',
  300,
  '2025-08-25', '16:00:00',
  '2025-08-27', '20:00:00'
),
(
  'Curso de Contabilidad para Emprendedores',
  'Aprende los conceptos mas importantes para emprender tu negocio y ser exitoso con tus finanzas',
  40,
  '2025-08-28', '18:00:00',
  '2025-08-30', '21:00:00'
);
