SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `bitacora_accesos` (
  `id_acceso` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `actividad` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `ciudad` (
  `id_ciudad` int NOT NULL,
  `nombre_ciudad` varchar(100) NOT NULL,
  `id_region` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `ciudad` (`id_ciudad`, `nombre_ciudad`, `id_region`) VALUES
(1, 'Chacabuco', 7),
(2, 'Cordillera', 7),
(3, 'Maipo', 7),
(4, 'Melipilla', 7),
(5, 'Santiago', 7),
(6, 'Talagante', 7);

CREATE TABLE `comuna` (
  `id_comuna` int NOT NULL,
  `nombre_comuna` varchar(100) NOT NULL,
  `id_ciudad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `comuna` (`id_comuna`, `nombre_comuna`, `id_ciudad`) VALUES
(1, 'Colina', 1),
(2, 'Lampa', 1),
(3, 'TilTil', 1),
(4, 'Pirque', 2),
(5, 'Puente Alto', 2),
(6, 'San Jose de Maipo', 2),
(7, 'Buin', 3),
(8, 'Calera de Tango', 3),
(9, 'Paine', 3),
(10, 'San Bernardo', 3),
(11, 'Alhué', 4),
(12, 'Curacaví', 4),
(13, 'Maria Pinto', 4),
(14, 'Melipilla', 4),
(15, 'San Pedro', 4),
(16, 'Cerrillos', 5),
(17, 'Cerro Navia', 5),
(18, 'Conchalí', 5),
(19, 'El Bosque', 5),
(20, 'Estacion Central', 5),
(21, 'Huechuraba', 5),
(22, 'Independencia', 5),
(23, 'La Cisterna', 5),
(24, 'La Florida', 5),
(25, 'La Granja', 5),
(26, 'La Pintana', 5),
(27, 'La Reina', 5),
(28, 'Las Condes', 5),
(29, 'Lo Barnechea', 5),
(30, 'Lo Espejo', 5),
(31, 'Lo Prado', 5),
(32, 'Macul', 5),
(33, 'Maipú', 5),
(34, 'Ñuñoa', 5),
(35, 'Pedro Aguirre Cerda', 5),
(36, 'Peñalolen', 5),
(37, 'Providencia', 5),
(38, 'Pudahuel', 5),
(39, 'Quilicura', 5),
(40, 'Quinta Normal', 5),
(41, 'Recoleta', 5),
(42, 'Renca', 5),
(43, 'San Joaquin', 5),
(44, 'San Miguel', 5),
(45, 'San Ramón', 5),
(46, 'Santiago', 5),
(47, 'Vitacura', 5),
(48, 'El Monte', 6),
(49, 'Isla de Maipo', 6),
(50, 'Padre Hurtado', 6),
(51, 'Peñaflor', 6),
(52, 'Talagante', 6);

CREATE TABLE `delincuente` (
  `id_delincuente` int NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `rut` varchar(12) DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `genero` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `apodo` varchar(100) DEFAULT NULL,
  `antecedentes` text,
  `foto` varchar(255) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `id_sector` int DEFAULT NULL,
  `estado_judicial` enum('Preso','Libre','Orden de arresto') NOT NULL DEFAULT 'Libre',
  `id_comuna` int DEFAULT NULL,
  `direccion_particular` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `delincuente` (`id_delincuente`, `nombre_completo`, `rut`, `edad`, `genero`, `apodo`, `antecedentes`, `foto`, `nacionalidad`, `id_sector`, `estado_judicial`, `id_comuna`, `direccion_particular`) VALUES
(12, 'Axel leopoldo Soto revira', '17.838.923-5', 34, 'Masculino', 'El Ragnar', 'Trafico ilícito de drogas', 'estaticos/img/delincuente4.jpg\r\n', 'Chileno', 7, 'Libre', 16, 'Farellones 7047'),
(13, 'Nikens Nikens Pierre du Perfum', '19.356.487-6', 25, 'Masculino', 'El Maluco', 'Robo con violencia', 'estaticos/img/delincuente5.jpg\r\n', 'Chileno', 1, 'Preso', 20, 'Toro Mazote 206'),
(14, 'Joao Edson Ureta Mardones', '17.424.065-5', 35, 'Masculino', 'El Joaito', 'Tráfico ilícito de drogas', 'estaticos/img/delincuente6.jpeg\r\n', 'Chileno', 4, 'Orden de arresto', 40, 'Rio Baker 5569'),
(15, 'Carlos Andrés Soto Muñoz', '19.456.789-2', 32, 'Masculino', 'El Flaco Soto', 'Condenado por robo con intimidación (2017), porte ilegal de arma (2019), reincidencia en hurto (2022).', 'estaticos/img/delincuente1.jpg', 'Chileno', 1, 'Preso', 20, 'Avenida Ecuador 4495'),
(16, 'Luis Eduardo Rivas Contreras', '17.234.567-8', 41, 'Masculino', 'El Gato', 'Antecedentes por tráfico de drogas (2016), amenazas a carabineros (2020), receptación (2023).', 'estaticos/img/delincuente2.jpg', 'Chileno', 5, 'Preso', 26, 'Pje. Catorce 1141'),
(17, 'José Manuel Paredes González', '18.987.654-3', 28, 'Masculino', 'El Chispa', 'Registro por robo de vehículo (2019), homicidio frustrado (2021), fuga de recinto penitenciario (2022).', 'estaticos/img/delincuente3.jpg', 'Chileno', 4, 'Preso', 17, 'Castelnovi 1724'),
(18, 'Camila Andrea Bormann Carrero', '19.695.452-9', 25, 'Femenino', 'La Chihuahua', 'Violencia domestica (2025)', 'estaticos/img/delincuente7.jpeg', 'Chileno', 4, 'Libre', 31, 'Capitán Trizano 1173'),
(22, 'Pedro Ignacio Molina Tapia', '18345678-1', 29, 'Masculino', 'El Bala', 'Participación en balaceras en zonas conflictivas, antecedentes por porte ilegal de arma.', 'estaticos/img/delincuente_default.png', 'Chileno', 3, 'Orden de arresto', 42, 'Pasaje Los Aromos 1234'),
(23, 'Andrés Rafael Peña Contreras', '17987321-4', 38, 'Masculino', 'El Cazador', 'Pertenencia a banda delictual dedicada al tráfico de armas y contrabando.', 'estaticos/img/delincuente_default.png', 'Chileno', 2, 'Libre', 39, 'Turquía 212'),
(24, 'Patricia Elena Guzmán Valdés', '19654321-2', 33, 'Femenino', 'La Pato', 'Violencia intrafamiliar reiterada, denuncias previas por agresión física a conviviente.', 'estaticos/img/delincuente_default.png', 'Chileno', 5, 'Libre', 26, 'Aromas 12923');

CREATE TABLE `delito` (
  `id_delito` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text,
  `id_tipo_delito` int DEFAULT NULL,
  `id_sector` int DEFAULT NULL,
  `id_institucion` int DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `delito` (`id_delito`, `fecha`, `descripcion`, `id_tipo_delito`, `id_sector`, `id_institucion`, `latitud`, `longitud`) VALUES
(1, '2025-01-01', 'Un individuo armado intimidó a una pareja para robarles sus pertenencias mientras caminaban por la vía pública. El delincuente huyó hacia una población cercana. Carabineros llegó minutos después tras el llamado de testigos.', 1, 1, 1, -33.44889000, -70.66926500),
(2, '2025-04-05', 'Un individuo fue detenido tras ser sorprendido intentando robar una tienda en el centro comercial. Fue capturado por Carabineros después de que la alarma de seguridad se activara.', 1, 1, 1, -33.44889000, -70.66926500),
(3, '2025-04-06', 'Una persona fue arrestada por posesión de drogas al ser interceptada por Carabineros en un sector de la comuna de La Florida. La sustancia incautada dio positivo a cocaína.', 3, 3, 1, -33.38248000, -70.58444000),
(4, '2025-04-07', 'Un hombre fue detenido por robo en un supermercado tras sustraer productos sin pagarlos. Fue capturado por seguridad y entregado a la PDI.', 5, 2, 2, -33.55387100, -70.65037000),
(5, '2025-04-07', 'Un automóvil fue robado durante la noche mientras estaba estacionado en una calle de la comuna de Maipú. El robo fue reportado por el propietario y la PDI está realizando las investigaciones.', 1, 5, 2, -33.54375400, -70.72151700),
(7, '2025-04-05', 'Un individuo fue detenido tras ser sorprendido intentando robar una tienda en el centro comercial. Fue capturado por Carabineros después de que la alarma de seguridad se activara.', 1, 1, 1, -33.44889000, -70.66926500),
(8, '2025-04-06', 'Una persona fue arrestada por posesión de drogas al ser interceptada por Carabineros en un sector de la comuna de La Florida. La sustancia incautada dio positivo a cocaína.', 3, 3, 1, -33.38248000, -70.58444000),
(9, '2025-04-07', 'Un hombre fue detenido por robo en un supermercado tras sustraer productos sin pagarlos. Fue capturado por seguridad y entregado a la PDI.', 5, 2, 2, -33.55387100, -70.65037000),
(10, '2025-04-07', 'Un automóvil fue robado durante la noche mientras estaba estacionado en una calle de la comuna de Maipú. El robo fue reportado por el propietario y la PDI está realizando las investigaciones.', 1, 5, 2, -33.54375400, -70.72151700),
(12, '2025-04-09', 'Mujer agrede a su pareja por infidelidad', 6, 5, 1, -33.52923900, -70.59215800);

CREATE TABLE `delito_delincuente` (
  `id_delito` int NOT NULL,
  `id_delincuente` int NOT NULL,
  `rol_en_el_delito` varchar(50) DEFAULT NULL,
  `id_tipo_delito` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `delito_delincuente` (`id_delito`, `id_delincuente`, `rol_en_el_delito`, `id_tipo_delito`) VALUES
(1, 15, 'autor', 1),
(1, 22, 'complice', 1),
(2, 13, 'autor', 1),
(2, 23, 'complice', 1),
(3, 12, 'autor', 3),
(4, 15, 'autor', 1),
(5, 17, 'autor', 5),
(5, 23, 'complice', 5),
(7, 13, 'autor', 1),
(8, 12, 'complice', 3),
(8, 14, 'autor', 3),
(9, 15, 'complice', 1),
(10, 16, 'autor', 5),
(12, 18, 'autor', 6),
(12, 24, 'complice', 6);

CREATE TABLE `delito_victima` (
  `id_delito` int NOT NULL,
  `id_victima` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `denuncia` (
  `id_denuncia` int NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` text,
  `medio` varchar(100) DEFAULT NULL,
  `lugar_delito` varchar(255) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_delito` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `institucion` (
  `id_institucion` int NOT NULL,
  `nombre_institucion` varchar(100) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_comuna` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `institucion` (`id_institucion`, `nombre_institucion`, `direccion`, `telefono`, `correo`, `latitud`, `longitud`, `id_comuna`) VALUES
(1, 'Carabineros de Chile', 'Avenida Bernardo O\'Higgins 1196', '(2) 2922 0000', NULL, -33.50245786, -70.77273080, 33),
(2, 'Seguridad OS-10', 'Huérfanos 540', '(2) 9220760', NULL, -33.43896791, -70.64460537, 46),
(3, 'Paz Ciudadana', 'Valenzuela Castillo 1881', '(2) 2 2 363 38 00', NULL, -33.43370080, -70.61127105, 37);

CREATE TABLE `region` (
  `id_region` int NOT NULL,
  `nombre_region` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `region` (`id_region`, `nombre_region`) VALUES
(1, 'Región de Arica y Parinacota'),
(2, 'Región de Tarapacá'),
(3, 'Región de Antofagasta'),
(4, 'Región de Atacama'),
(5, 'Región de Coquimbo'),
(6, 'Región de Valparaíso'),
(7, 'Región Metropolitana de Santiago'),
(8, 'Región del Libertador General Bernardo O\'Higgins'),
(9, 'Región del Maule'),
(10, 'Región de Ñuble'),
(11, 'Región del Biobío'),
(12, 'Región de La Araucanía'),
(13, 'Región de Los Ríos'),
(14, 'Región de Los Lagos'),
(15, 'Región de Aysén del General Carlos Ibáñez del Campo'),
(16, 'Región de Magallanes y de la Antártica Chilena');

CREATE TABLE `sector` (
  `id_sector` int NOT NULL,
  `nombre_sector` varchar(100) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_institucion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `sector` (`id_sector`, `nombre_sector`, `latitud`, `longitud`, `id_institucion`) VALUES
(1, 'Centro', -33.44889000, -70.66926500, 1),
(2, 'Norte', -33.39529000, -70.68050400, 1),
(3, 'Nororiente', -33.38248000, -70.58444000, 1),
(4, 'Norponiente', -33.37015000, -70.73784000, 1),
(5, 'Sur', -33.55387100, -70.65037000, 1),
(6, 'Suroriente', -33.52923900, -70.59215800, 1),
(7, 'Surponiente', -33.54375400, -70.72151700, 1);

CREATE TABLE `sentencia` (
  `id_sentencia` int NOT NULL,
  `id_delincuente` int DEFAULT NULL,
  `tribunal` varchar(100) DEFAULT NULL,
  `fecha_sentencia` date DEFAULT NULL,
  `condena` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `tipo_delito` (
  `id_tipo_delito` int NOT NULL,
  `nombre_tipo` varchar(100) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tipo_delito` (`id_tipo_delito`, `nombre_tipo`, `descripcion`) VALUES
(1, 'Robo con violencia o intimidación', 'Delito que consiste en apoderarse de una cosa mueble ajena con ánimo de lucro, empleando violencia física o amenazas sobre las personas para conseguir el propósito. Regulado en el Art. 436 del Código Penal.'),
(2, 'Homicidio', 'Delito que consiste en causar la muerte a otra persona. Puede ser simple, calificado, frustrado o tentado. Artículos 391 y siguientes del Código Penal.'),
(3, 'Tráfico ilícito de drogas', 'Conducta que implica producir, transportar, distribuir o vender sustancias estupefacientes o psicotrópicas prohibidas. Regulado por la Ley 20.000.'),
(4, 'Porte ilegal de arma de fuego', 'Delito que consiste en portar armas de fuego sin la autorización correspondiente. Regulado por la Ley 17.798 sobre control de armas.'),
(5, 'Receptación', 'Delito que consiste en adquirir, vender, guardar o esconder bienes robados o hurtados, sabiendo su procedencia ilícita. Art. 456 bis A del Código Penal.'),
(6, 'Violencia intrafamiliar', 'Ejercicio de violencia física o psicológica en contra de un miembro del grupo familiar. Regulado por la Ley 20.066.'),
(7, 'Abuso sexual', 'Delito que consiste en realizar actos de significación sexual sobre otra persona sin su consentimiento, sin llegar a la violación. Art. 366 y siguientes del Código Penal.'),
(8, 'Estafa y otras defraudaciones', 'Acción de engañar a otra persona con el fin de obtener un beneficio económico indebido. Art. 468 y siguientes del Código Penal.'),
(9, 'Amenazas', 'Consiste en intimidar a otra persona con causarle un mal que pueda afectarla a ella o a sus bienes. Tipificado en el Art. 296 del Código Penal.'),
(10, 'Conducción en estado de ebriedad', 'Delito que consiste en conducir un vehículo motorizado con una concentración de alcohol superior a la permitida. Sancionado por la Ley de Tránsito 18.290.');

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('Administrador','JefeZona','Operador','Visitante','AdministradorGeneral') DEFAULT 'Visitante',
  `id_institucion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuario` (`id_usuario`, `nombre_completo`, `rut`, `correo`, `contrasena`, `rol`, `id_institucion`) VALUES
(1, 'Joao Edson Ureta Mardones', '17424065-5', 'admin@gmail.com', '$2y$10$a88Zv/rSS2D6Cwir.FszjOVMOO.9CWv9EGmPLml4akSKdezorZnwi', 'AdministradorGeneral', 1),
(4, 'JefeZona Carabineros', '18848729-7', 'carabinero_Jzona@gmail.com', '$2y$10$vnw14NJBO7qcLxAEjsCuyeZcHwx1WLoYqLyllftUzyCfbqHny8H9W', 'JefeZona', 1);

CREATE TABLE `victima` (
  `id_victima` int NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `sexo` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `bitacora_accesos`
  ADD PRIMARY KEY (`id_acceso`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `id_region` (`id_region`);

ALTER TABLE `comuna`
  ADD PRIMARY KEY (`id_comuna`),
  ADD KEY `id_ciudad` (`id_ciudad`);

ALTER TABLE `delincuente`
  ADD PRIMARY KEY (`id_delincuente`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `id_sector` (`id_sector`),
  ADD KEY `id_comuna` (`id_comuna`);

ALTER TABLE `delito`
  ADD PRIMARY KEY (`id_delito`),
  ADD KEY `id_tipo_delito` (`id_tipo_delito`),
  ADD KEY `id_sector` (`id_sector`),
  ADD KEY `id_institucion` (`id_institucion`);

ALTER TABLE `delito_delincuente`
  ADD PRIMARY KEY (`id_delito`,`id_delincuente`),
  ADD KEY `id_delincuente` (`id_delincuente`),
  ADD KEY `id_tipo_delito` (`id_tipo_delito`);

ALTER TABLE `delito_victima`
  ADD PRIMARY KEY (`id_delito`,`id_victima`),
  ADD KEY `id_victima` (`id_victima`);

ALTER TABLE `denuncia`
  ADD PRIMARY KEY (`id_denuncia`),
  ADD KEY `id_delito` (`id_delito`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id_institucion`),
  ADD KEY `id_comuna` (`id_comuna`);

ALTER TABLE `region`
  ADD PRIMARY KEY (`id_region`);

ALTER TABLE `sector`
  ADD PRIMARY KEY (`id_sector`),
  ADD KEY `id_institucion` (`id_institucion`);

ALTER TABLE `sentencia`
  ADD PRIMARY KEY (`id_sentencia`),
  ADD KEY `id_delincuente` (`id_delincuente`);

ALTER TABLE `tipo_delito`
  ADD PRIMARY KEY (`id_tipo_delito`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_institucion` (`id_institucion`);

ALTER TABLE `victima`
  ADD PRIMARY KEY (`id_victima`);


ALTER TABLE `bitacora_accesos`
  MODIFY `id_acceso` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `comuna`
  MODIFY `id_comuna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

ALTER TABLE `delincuente`
  MODIFY `id_delincuente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `delito`
  MODIFY `id_delito` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `denuncia`
  MODIFY `id_denuncia` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `institucion`
  MODIFY `id_institucion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `region`
  MODIFY `id_region` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `sector`
  MODIFY `id_sector` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `sentencia`
  MODIFY `id_sentencia` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipo_delito`
  MODIFY `id_tipo_delito` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `victima`
  MODIFY `id_victima` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `bitacora_accesos`
  ADD CONSTRAINT `bitacora_accesos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comuna`
  ADD CONSTRAINT `comuna_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `delincuente`
  ADD CONSTRAINT `delincuente_ibfk_1` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id_sector`) ON DELETE CASCADE,
  ADD CONSTRAINT `delincuente_ibfk_2` FOREIGN KEY (`id_comuna`) REFERENCES `comuna` (`id_comuna`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `delito`
  ADD CONSTRAINT `delito_ibfk_1` FOREIGN KEY (`id_tipo_delito`) REFERENCES `tipo_delito` (`id_tipo_delito`) ON DELETE CASCADE,
  ADD CONSTRAINT `delito_ibfk_2` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id_sector`) ON DELETE CASCADE,
  ADD CONSTRAINT `delito_ibfk_3` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`) ON DELETE CASCADE;

ALTER TABLE `delito_delincuente`
  ADD CONSTRAINT `delito_delincuente_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  ADD CONSTRAINT `delito_delincuente_ibfk_2` FOREIGN KEY (`id_delincuente`) REFERENCES `delincuente` (`id_delincuente`) ON DELETE CASCADE,
  ADD CONSTRAINT `delito_delincuente_ibfk_3` FOREIGN KEY (`id_tipo_delito`) REFERENCES `tipo_delito` (`id_tipo_delito`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `delito_victima`
  ADD CONSTRAINT `delito_victima_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  ADD CONSTRAINT `delito_victima_ibfk_2` FOREIGN KEY (`id_victima`) REFERENCES `victima` (`id_victima`) ON DELETE CASCADE;

ALTER TABLE `denuncia`
  ADD CONSTRAINT `denuncia_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  ADD CONSTRAINT `denuncia_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

ALTER TABLE `institucion`
  ADD CONSTRAINT `institucion_ibfk_1` FOREIGN KEY (`id_comuna`) REFERENCES `comuna` (`id_comuna`) ON DELETE CASCADE;

ALTER TABLE `sector`
  ADD CONSTRAINT `sector_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`);

ALTER TABLE `sentencia`
  ADD CONSTRAINT `sentencia_ibfk_1` FOREIGN KEY (`id_delincuente`) REFERENCES `delincuente` (`id_delincuente`) ON DELETE CASCADE;

ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
