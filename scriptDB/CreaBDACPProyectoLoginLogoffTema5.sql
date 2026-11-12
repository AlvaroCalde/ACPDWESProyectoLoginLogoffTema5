

CREATE DATABASE IF NOT EXISTS DBACPDWESProyectoLoginLogoffTema5;
USE DBACPDWESProyectoLoginLogoffTema5;

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

CREATE USER 'userACPDWESProyectoLoginLogoffTema5'@'%' IDENTIFIED BY 'paso';
GRANT ALL ON DBACPDWESProyectoLoginLogoffTema5.* to 'userACPDWESProyectoLoginLogoffTema5'@'%';
