-- ─────────────────────────────────────────────────────────────
-- init.sql  —  Base de datos crud_clientes
-- Corregido: encoding UTF-8 y columna phone_number
-- ─────────────────────────────────────────────────────────────

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `crud_clientes`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `crud_clientes`;

-- ─────────────────────────────────────────────────────────────
-- Tabla: libros
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `libros` (
  `idlibros`   INT          NOT NULL AUTO_INCREMENT,
  `titulo`     VARCHAR(255) NOT NULL,
  `autor`      VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlibros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `libros` (`titulo`, `autor`) VALUES
  ('Cien años de soledad', 'Gabriel García Márquez'),
  ('El principito',        'Antoine de Saint-Exupéry');

-- ─────────────────────────────────────────────────────────────
-- Tabla: clientes
-- Nota: columna se llama phone_number (igual que en api.php)
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `clientes` (
  `id`           INT          NOT NULL,
  `name`         VARCHAR(255) NOT NULL,
  `email`        VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(50)  DEFAULT NULL,
  `address`      TEXT,
  `idlibros`     INT          DEFAULT NULL,
  `created_at`   TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idlibros` (`idlibros`),
  CONSTRAINT `clientes_ibfk_1`
    FOREIGN KEY (`idlibros`) REFERENCES `libros` (`idlibros`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
