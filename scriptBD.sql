CREATE TABLE IF NOT EXISTS Autor (
    id INT PRIMARY KEY,
    nombre VARCHAR(15) NOT NULL,
    apellidos VARCHAR(25) NOT NULL,
    nacionalidad VARCHAR(10) NOT NULL
);  

INSERT INTO Autor (id, nombre, apellidos, nacionalidad) VALUES
(0, 'J. R. R.', 'Tolkien', 'Inglaterra'),
(1, 'Isaac', 'Asimov', 'Rusia');

CREATE TABLE IF NOT EXISTS Libro (
    id INT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    f_publicacion DATE NOT NULL,
    id_autor INT,
    FOREIGN KEY (id_autor) REFERENCES Autor(id)
);  

INSERT INTO Libro (id, titulo, f_publicacion, id_autor) VALUES
(0, 'El Hobbit', '1937/09/21', 0),
(1, 'La Comunidad del Anillo', '1954/07/29', 0),
(2, 'Las dos torres', '1954/11/11', 0),
(3, 'El retorno del Rey', '1955/10/20', 0),
(4, 'Un guijarro en el cielo', '1950/01/19', 1),
(5, 'Fundación', '1951/06/01', 1),
(6, 'Yo, robot', '1950/12/02', 1);
