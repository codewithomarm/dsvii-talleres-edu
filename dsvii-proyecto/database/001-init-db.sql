CREATE DATABASE IF NOT EXISTS dsvii_final;
USE dsvii_final;

-- 1. Tablas de catálogo
CREATE TABLE cedula_category (
  code VARCHAR(2) PRIMARY KEY,
  description VARCHAR(100) NOT NULL
);

INSERT INTO cedula_category (code, description) VALUES
  ('NA', 'Panameño por nacimiento'),
  ('N',   'Naturalizado'),
  ('E',   'Extranjero domiciliado'),
  ('PE',  'Panameño nacido en el extranjero'),
  ('PI',  'Población indígena');

CREATE TABLE province (
  code SMALLINT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

INSERT INTO province (code, name) VALUES
  (1,  'Bocas del Toro'),
  (2,  'Coclé'),
  (3,  'Colón'),
  (4,  'Chiriquí'),
  (5,  'Darién'),
  (6,  'Herrera'),
  (7,  'Los Santos'),
  (8,  'Panamá'),
  (9,  'Veraguas'),
  (10, 'Guna Yala, Madugandí, Wargandí'),
  (11, 'Emberá Wounaan'),
  (12, 'Ngäbe-Buglé'),
  (13, 'Panamá Oeste');

-- 2. Tabla de cédulas
CREATE TABLE cedula (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  category_code VARCHAR(2) NOT NULL,
  province_code SMALLINT,
  letter_prefix VARCHAR(2),
  tomo INTEGER NOT NULL CHECK (tomo > 0),
  asiento INTEGER NOT NULL CHECK (asiento > 0),
  CONSTRAINT uq_cedula_full UNIQUE (category_code, province_code, letter_prefix, tomo, asiento),
  FOREIGN KEY (category_code) REFERENCES cedula_category(code) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (province_code) REFERENCES province(code) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- 3. Tabla de usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT false,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  cedula_id BIGINT NOT NULL UNIQUE,
  FOREIGN KEY (cedula_id) REFERENCES cedula(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 4. Tabla de talleres
CREATE TABLE talleres (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descripcion VARCHAR(300),
  cupo_maximo INT NOT NULL,
  fecha_inicio DATE,
  hora_inicio TIME,
  fecha_fin DATE,
  hora_fin TIME
);

-- 5. Tabla de inscripciones
CREATE TABLE inscripciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  taller_id INT NOT NULL,
  fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (usuario_id, taller_id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (taller_id) REFERENCES talleres(id) ON DELETE CASCADE
);
