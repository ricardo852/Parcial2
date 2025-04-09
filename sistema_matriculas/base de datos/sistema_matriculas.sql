-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2025 a las 18:20:05
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_matriculas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_estudiantes_reprobados` (IN `p_semestre` VARCHAR(20))  BEGIN
    SELECT e.id_estudiante, e.cedula, e.nombre, e.apellido, 
           c.nombre_curso, m.nota_final
    FROM estudiantes e
    JOIN matriculas m ON e.id_estudiante = m.id_estudiante
    JOIN cursos c ON m.id_curso = c.id_curso
    WHERE m.semestre = p_semestre AND m.nota_final < 70
    ORDER BY e.apellido, e.nombre;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `matricular_estudiante_multiple` (IN `p_id_estudiante` INT, IN `p_ids_cursos` TEXT, IN `p_semestre` VARCHAR(20))  BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE curso_id INT;
    DECLARE cursos_count INT;
    DECLARE exit_handler BOOLEAN DEFAULT FALSE;
    DECLARE cursos_ids TEXT;
    
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET exit_handler = TRUE;
    
    SET cursos_ids = p_ids_cursos;
    SET cursos_count = (LENGTH(cursos_ids) - LENGTH(REPLACE(cursos_ids, ',', ''))) + 1;
    
    START TRANSACTION;
    
    WHILE i < cursos_count AND NOT exit_handler DO
        SET curso_id = SUBSTRING_INDEX(SUBSTRING_INDEX(cursos_ids, ',', i+1), ',', -1);
        
        INSERT INTO matriculas (id_estudiante, id_curso, semestre)
        VALUES (p_id_estudiante, curso_id, p_semestre);
        
        SET i = i + 1;
    END WHILE;
    
    IF exit_handler THEN
        ROLLBACK;
        SELECT 'Error en la matrícula. Se ha realizado un rollback.' AS mensaje;
    ELSE
        COMMIT;
        SELECT CONCAT('Matrícula exitosa para ', i, ' cursos') AS mensaje;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `codigo_curso` varchar(20) NOT NULL,
  `nombre_curso` varchar(100) NOT NULL,
  `creditos` int(11) NOT NULL,
  `cupo_maximo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `codigo_curso`, `nombre_curso`, `creditos`, `cupo_maximo`) VALUES
(1, '10203060', 'ricardo', 8, 0),
(2, '19 ', 'jon', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `cedula`, `nombre`, `apellido`, `email`, `telefono`, `fecha_nacimiento`) VALUES
(2, '10045124852', 'Ricardo uz', 'Monca', 'andreseraso009@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_academico`
--

CREATE TABLE `historial_academico` (
  `id_historial` int(11) NOT NULL,
  `id_matricula` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `semestre` varchar(20) NOT NULL,
  `nota_final` decimal(3,1) DEFAULT NULL,
  `estado` enum('aprobado','reprobado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id_matricula` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `semestre` varchar(20) NOT NULL,
  `fecha_matricula` datetime DEFAULT current_timestamp(),
  `estado` enum('activa','completada','reprobada') DEFAULT 'activa',
  `nota_final` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `matriculas`
--
DELIMITER $$
CREATE TRIGGER `verificar_cursos_matriculados` BEFORE INSERT ON `matriculas` FOR EACH ROW BEGIN
    DECLARE total_cursos INT;
    
    SELECT COUNT(*) INTO total_cursos
    FROM matriculas
    WHERE id_estudiante = NEW.id_estudiante AND semestre = NEW.semestre;
    
    IF total_cursos >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un estudiante no puede matricular más de 5 cursos por semestre';
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `codigo_curso` (`codigo_curso`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `historial_academico`
--
ALTER TABLE `historial_academico`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_matricula` (`id_matricula`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id_matricula`),
  ADD UNIQUE KEY `id_estudiante` (`id_estudiante`,`id_curso`,`semestre`),
  ADD KEY `id_curso` (`id_curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial_academico`
--
ALTER TABLE `historial_academico`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id_matricula` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_academico`
--
ALTER TABLE `historial_academico`
  ADD CONSTRAINT `historial_academico_ibfk_1` FOREIGN KEY (`id_matricula`) REFERENCES `matriculas` (`id_matricula`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
