

CREATE DATABASE IF NOT EXISTS DBACPDWESProyectoTema4;
USE DBACPDWESProyectoTema4;

CREATE TABLE IF NOT EXISTS T02_Departamento (
    T02_CodDepartamento CHAR(3) NOT NULL,
    T02_DescDepartamento VARCHAR(255) NOT NULL,
    T02_FechaCreacionDepartamento DATETIME NOT NULL,
    T02_VolumenDeNegocio FLOAT NOT NULL,
    T02_FechaBajaDepartamento DATETIME NULL,
    PRIMARY KEY (T02_CodDepartamento)
);

CREATE USER 'userACPDWESProyectoTema4'@'%' IDENTIFIED BY 'paso';
GRANT ALL ON DBACPDWESProyectoTema4.* to 'userACPDWESProyectoTema4'@'%';
