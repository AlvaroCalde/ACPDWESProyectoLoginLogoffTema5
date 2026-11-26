CREATE TABLE IF NOT EXISTS T02_Departamento (
    T02_CodDepartamento CHAR(3) NOT NULL,
    T02_DescDepartamento VARCHAR(255) NOT NULL,
    T02_FechaCreacionDepartamento DATETIME NOT NULL,
    T02_VolumenDeNegocio FLOAT NOT NULL,
    T02_FechaBajaDepartamento DATETIME NULL,
    PRIMARY KEY (T02_CodDepartamento)
);
CREATE TABLE IF NOT EXISTS T01_Usuario (
    T01_CodUsuario VARCHAR(8) NOT NULL PRIMARY KEY,
    T01_Password VARCHAR(255) NOT NULL,
    T01_DescUsuario VARCHAR(255) NOT NULL,
    T01_NumConexiones INT UNSIGNED NOT NULL DEFAULT 0,
    T01_FechaHoraUltimaConexion DATETIME  DEFAULT NULL,
    T01_Perfil ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
    T01_ImagenUsuario LONGBLOB NULL,
    CHECK (CHAR_LENGTH(T01_CodUsuario) BETWEEN 4 AND 8)
);

INSERT INTO T02_Departamento 
(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) 
VALUES
('VTA', 'Departamento de Ventas y Comercialización', '2015-01-15 09:00:00', 1250500.75, NULL),
('RCH', 'Recursos Humanos y Talento', '2015-01-15 09:00:00', 45000.00, NULL),
('ING', 'Ingeniería y Desarrollo de Software', '2018-06-01 10:30:00', 850200.50, NULL),
('FIN', 'Finanzas, Contabilidad y Tesorería', '2015-01-15 09:00:00', 320000.00, NULL),
('MKT', 'Marketing Digital', '2019-02-20 08:15:00', 150000.25, '2025-12-31 18:00:00');

INSERT INTO T01_Usuario 
(T01_CodUsuario, T01_Password, T01_DescUsuario)
VALUES
('heraclio', SHA2('heracliopaso',256), 'Heraclio Borbujo'),
('alvaro', SHA2('alvaropaso',256), 'Alvaro Calderon'),
('moises', SHA2('moisespaso',256), 'Moises Alberto Dominguez'),
('juanmi', SHA2('juanmipaso',256), 'Juan Miguel Dominguez'),
('juan', SHA2('juanpaso',256), 'Juan Rivera'),
('santiago', SHA2('santiagopaso',256), 'Santiago Gonzalez'),
('yolanda', SHA2('yolandapaso',256), 'Yolanda Rodriguez');

