-- Asegúrate de estar usando la base de datos correcta
USE dsvii_final;

-- 1. Insertar la cédula
INSERT INTO cedula (
  category_code, province_code, letter_prefix, tomo, asiento
) VALUES (
  'NA', 8, NULL, 920, 840
);

-- 2. Insertar el usuario test
-- Se asume que la cédula anterior fue insertada y es la última (AUTO_INCREMENT)

INSERT INTO usuarios (
  nombre, username, email, password_hash, is_admin, cedula_id
)
VALUES (
  'Test User',
  'testuser001',
  'testuser@email.com',
  '$2y$10$phSgN0IhAjWrCN6k4gnwnuF5FduXAd4QsyGyyT68/9M04PTtFZ0Ie',
  false,
  LAST_INSERT_ID()
);