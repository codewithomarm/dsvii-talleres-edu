-- Usar la base de datos correcta
USE dsvii_final;

-- 1. Insertar la cédula
INSERT INTO cedula (
  category_code, province_code, letter_prefix, tomo, asiento
) VALUES (
  'NA', 8, NULL, 911, 614
);

-- 2. Insertar el usuario administrador
-- Se asume que la cédula anterior fue insertada y es la última (AUTO_INCREMENT)

INSERT INTO usuarios (
  nombre, username, email, password_hash, is_admin, cedula_id
)
VALUES (
  'Admin User',
  'adminuser001',
  'adminuser@email.com',
  '$2y$10$phSgN0IhAjWrCN6k4gnwnuF5FduXAd4QsyGyyT68/9M04PTtFZ0Ie',
  true,
  LAST_INSERT_ID()
);