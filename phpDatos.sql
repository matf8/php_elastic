SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `clientes` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `ci` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL UNIQUE,
  `password` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo`  varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL UNIQUE,
  `fNac` DATE NULL,
  `imagen` LONGBLOB NULL,
  `estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci
);

INSERT INTO `clientes` (`nombre`, `ci`, `password`, `correo`, `fNac`, `imagen`, `estado`) VALUES
('Jaime Cruz', '123456', 'tb22', 'ha2a@gmail.com', '1992-05-15', '', 'Aceptado'),
('Gil Roberto', '541451', 'tb22', 'br2a@gmail.com', '1950-10-25', '', 'Aceptado'),
('Jesus Baldo', '567856', 'tb22', 'jl1a@gmail.com', '1968-08-10' , '', 'Aceptado'),
('Orman Dure', '454321', 'tb22', 'kap2@gmail.com', '1978-02-25', '', 'Aceptado'),
('Roberto Margi', '231122', 'tb22', 'ha1s2a@gmail.com', '1992-05-15', '', 'Aceptado'),
('Megan Coloer', '456767', 'tb22', 'brs1a@gmail.com', '1950-10-25', '', 'Aceptado'),
('Agustin Lero', '788545', 'tb22', 'jal@gmail.com', '1968-08-10' , '', 'Aceptado'),
('Jalip Turk', '562441', 'tb22', 'ka1p@gmail.com', '1978-02-25', '', 'Aceptado'),
('German Toll', '23112', 'tb22', 'has2a@gmail.com', '1992-05-15', '', 'Aceptado'),
('Megan Coloer', '452767', 'tb22', 'br2sa@gmail.com', '1950-10-25', '', 'Aceptado'),
('Carmen Torkz', '782545', 'tb22', 'ja1l@gmail.com', '1968-08-10' , '', 'Aceptado'),
('Julain Tucsa', '554421', 'tb22', 'ka1p3@gmail.com', '1978-02-25', '', 'Aceptado'),
('Mathias Fernandez', '5026656', 'tb22', 'mathihd38@gmail.com', '1996-02-10', '', 'Aceptado'),
('Carlos Garcia', '4487442', 'tb22', 'charliexstar4@gmail.com', '1991-12-26', '', 'Aceptado'),
('Manuel Biurrun', '5346301', 'tb22', 'manu.biurrun@gmail.com', '1999-05-31', '', 'Aceptado'),
('Juan Rodriguez', '12345678', 'tb22', 'jfrrsa@gmail.com', '1955-06-14', '', 'Aceptado'),
('Martha Gimenez', '87654321', 'tb22', 'martha.gimenez@gmail.com', '1965-03-13', '', 'Aceptado'),
('Valeria Curbelo', '12348765', 'tb22', 'docente.valeriacurbelo@gmail.com', '1970-11-25', '', 'Aceptado');

CREATE TABLE IF NOT EXISTS `administradores` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ci` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL UNIQUE,
  `password` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
);

INSERT INTO `administradores` (`ci`, `password`) VALUES
('admin', 'admin');

CREATE TABLE IF NOT EXISTS `catalogos` (
  `idCatalogo` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `categoria` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL UNIQUE
);

INSERT INTO `catalogos` (`categoria`) VALUES
('cocina'),
('heladera'),
('freezer'),
('lavarropa'),
('secarropa'),
('microonda'),
('gaming');

CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL UNIQUE,
  `precio` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NULL,
  `imagen` LONGBLOB NULL,
  `categoria` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stock` INT(5) UNSIGNED NOT NULL,
  FOREIGN KEY (categoria) REFERENCES catalogos (categoria) ON DELETE CASCADE ON UPDATE CASCADE 
);

INSERT INTO `productos` (`nombre`, `precio`, `descripcion`, `imagen`, `categoria`, `stock`) VALUES
("Supergas Blanca 50", 200, "Panavox 4 hornallas 26.8 kg garantia 1 año", '', 'cocina', 100),
("Supergas Negra c-700", 400, "Cocina James c-700 V Titanium 30.8 kg garantia 1 año", '', 'cocina', 100),
("Heladera Blanca 400L", 350, "Heladera inverter no frost Samsung RT35K573B easy clean steel con freezer 361L 220V garantia 1 año", '', 'heladera', 100),
("Heladera Blanca 500L", 400, "Heladera 361L 520V garantia 1 año", '', 'heladera', 100),
("Lavarropas Blanco 6KG", 150, "Lavarropas automático Enxuta LENX765 blanco 6kg 220 V - 240 V", '', 'lavarropa', 100),
("Lavarropas James 10KG", 250, "Lavarropas automático James JAMX765 blanco 6kg 220 V - 240 V", '', 'lavarropa', 100),
("Microondas panavox", 50, "Microondas panavox", '', 'microonda', 100),
("Microondas james", 150, "Microondas james 40XMA ", '', 'microonda', 100),
("Teclado mecanico", 150, "Teclado Gamer negro con lucesitas led", '', 'gaming', 100),
("Mouse", 150, "Mouse Gamer negro con lucesitas led RGB", '', 'gaming', 500),
("Luces LED RGB", 50, "Lucesitas led", '', 'gaming', 15);

CREATE TABLE IF NOT EXISTS `carritos` (
  `idCarrito` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  FOREIGN KEY (usuario) REFERENCES clientes (correo) ON DELETE CASCADE ON UPDATE CASCADE 
);

INSERT INTO `carritos` (`usuario`, `estado`) VALUES
("charliexstar4@gmail.com", "Aceptado"),
("manu.biurrun@gmail.com", "Aceptado"),
("mathihd38@gmail.com", "Aceptado"),
("jfrrs@hotmail.com", "Aceptado"),
("martha.gimenez@gmail.com", "Aceptado"),
("docente.valeriacurbelo@gmail.com", "Aceptado");

CREATE TABLE IF NOT EXISTS `productos_carrito` (
  `idProductoCarrito` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `carrito` int(11) NOT NULL, 
	`producto` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,  
  `cantidad` int(5) UNSIGNED NOT NULL,
	FOREIGN KEY (carrito) REFERENCES carritos (idCarrito) ON DELETE CASCADE,
	FOREIGN KEY (producto) REFERENCES productos (nombre) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE IF NOT EXISTS `compras` (
  `idCompra` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`fecha` date NOT NULL, 
  `metodo` varchar(15),
  `total` int(20) UNSIGNED NOT NULL,
  FOREIGN KEY (usuario) REFERENCES clientes (correo) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `compras` (`usuario`,`fecha`, `metodo`,`total`) VALUES
('charliexstar4@gmail.com', "2022-06-28", 'visa', 1500),
('manu.biurrun@gmail.com', "2022-06-28", 'mastercard', 900),
('mathihd38@gmail.com', "2022-06-28", 'visa', 1000),
('docente.valeriacurbelo@gmail.com', "2022-06-28", 'paypal', 2500),
('martha.gimenez@gmail.com', "2022-06-28", 'visa', 100),
('jfrrs@hotmail.com', "2022-06-28", 'visa', 100);


CREATE TABLE IF NOT EXISTS `productos_compra` (
  `idProductosCompra` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,    
  `compra` int(11) NOT NULL, 
  `producto` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `unidades` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (compra) REFERENCES compras (idCompra) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (producto) REFERENCES productos (nombre) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `productos_compra` (`compra`, `producto`,`unidades`) VALUES
(1, "Teclado mecanico", 10),
(1, "Lavarropas Blanco 6KG", 1),
(1, "Mouse", 1),
(2, "Teclado mecanico", 1),
(2, "Heladera Blanca 500L", 40),
(3, "Supergas Negra c-700", 30),
(3, "Teclado mecanico", 20),
(4, "Lavarropas Blanco 6KG", 10),
(4, "Teclado mecanico", 20),
(5, "Supergas Blanca 50", 6),
(5, "Teclado mecanico", 5),
(6, "Heladera Blanca 500L", 1),
(6, "Mouse", 1);

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idComentario` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `texto` varchar(100) NOT NULL,
  `valoracion` int(1) UNSIGNED NOT NULL, 
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,    
  FOREIGN KEY (usuario) REFERENCES clientes (correo) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (producto) REFERENCES productos (nombre) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `comentarios` (`texto`, `valoracion`,`usuario`, `producto`) VALUES
("Muy bueno compraria otra vez!", "5", "charliexstar4@gmail.com", "Teclado mecanico"),
("Muy bueno!", "4", "charliexstar4@gmail.com", "Mouse"),
("Malaso", "1", "charliexstar4@gmail.com", "Lavarropas Blanco 6KG"),
("Impresionante teclado", "5", "manu.biurrun@gmail.com", "Teclado mecanico"),
("Muy buena heladera", "5", "manu.biurrun@gmail.com", "Heladera Blanca 500L");
