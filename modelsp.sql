-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2020 at 12:43 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `modelsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnomateria`
--

CREATE TABLE `alumnomateria` (
  `legajo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `alumnomateria`
--

INSERT INTO `alumnomateria` (`legajo`, `idMateria`) VALUES
(3, 1),
(3, 2),
(3, 2),
(3, 2),
(12, 4),
(12, 4),
(12, 4),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `materias`
--

CREATE TABLE `materias` (
  `idMateria` int(11) NOT NULL,
  `materia` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `cupos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `materias`
--

INSERT INTO `materias` (`idMateria`, `materia`, `cuatrimestre`, `cupos`) VALUES
(1, 'ProgramacionIII', 3, 49),
(2, 'Matematica', 2, 49),
(3, 'Matematica', 2, 50),
(4, 'Estadistica', 3, 46),
(5, 'Estadistica', 3, 50),
(6, 'Programacion1', 1, 50),
(7, 'Plastica', 1, 50),
(8, 'P3', 3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `notas`
--

CREATE TABLE `notas` (
  `idAlumno` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `idProfesor` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `notas`
--

INSERT INTO `notas` (`idAlumno`, `nota`, `idProfesor`, `idMateria`) VALUES
(4, 9, 4, 4),
(4, 9, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `profesormateria`
--

CREATE TABLE `profesormateria` (
  `legajo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `profesormateria`
--

INSERT INTO `profesormateria` (`legajo`, `idMateria`) VALUES
(4, 5),
(6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `legajo` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`legajo`, `email`, `tipo`, `clave`, `nombre`) VALUES
(1, 'alguien@gmail.com', 'alumno', '1234', 'alguien'),
(2, 'hola@hotmail', 'alumno', '456', 'hola'),
(3, 'juli@gmail.com', 'alumno', 'progra3', 'juli'),
(4, 'usuario2@gmail.com', 'profesor', '$2y$10$LmwfROpSkk5TaZ7tVKeKt.EHEIODSqoujcYCEuQ.kLA', 'usuario'),
(5, 'admin1@gmail.com', 'admin', '$2y$10$365vpCoMVuKFRKXzec8P0OKnaiTP3hGBQ.RVQEz2d5z', 'admin'),
(6, 'profesor34@gmail.com', 'profesor', '$2y$10$24qmoY7XQAOrcp5/rihP1un83SwcQifY24mv7TPOUQI', 'Profe43'),
(12, 'admin@mail.com', 'alumno', '$2y$10$T5xI1Jz.FjBtBeT0XagDluNf1XwxG461j6vyCTkLKTd', 'Admin'),
(13, 'admin2@mail.com', 'admin', '$2y$10$0jkniFbLCye75THfbTsDyu2OUi7yPEmr9j05yu4yfSS', 'Admin2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`idMateria`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`legajo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materias`
--
ALTER TABLE `materias`
  MODIFY `idMateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `legajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
