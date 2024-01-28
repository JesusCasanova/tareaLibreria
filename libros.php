<?php

class Libros
{
    private $conexion;

    public function conexion($servidor, $base_datos, $usuario, $contraseña)
    {
        try {
            $this->conexion = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            return null;
        }
    }

    public function convertirFormatoFecha($fecha)
    {
        $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
        if (!$fechaObj) {
            return $fecha; 
        }
        return $fechaObj->format('d/m/Y'); 
    }
    
    
    public function consultarAutores($pdo, $id = null)
{
    try {
        $sql = $id === null ? "SELECT * FROM Autor" : "SELECT * FROM Autor WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($id !== null) {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        $stmt->execute();

        if ($id !== null) {
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);
            return $resultado ? $resultado : null;
        } else {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
    } catch (PDOException $e) {
        error_log("Error de consulta: " . $e->getMessage());
        return null;
    }
}



public function consultarLibros($pdo, $id)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM Libro WHERE id_autor = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $libros = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($libros as $libro) {
            $libro->id = (string)$libro->id;
            $libro->id_autor = (string)$libro->id_autor;

            if (isset($libro->f_publicacion)) {
                $timestamp = strtotime($libro->f_publicacion);
                $libro->f_publicacion = date('d/m/Y', $timestamp);
            }
        }

        return $libros;

    } catch (PDOException $e) {
        error_log("¡Error!: " . $e->getMessage());
        return null;
    }
}

public function consultarDatosLibro($pdo, $id_libro)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM Libro WHERE id = :id_libro");
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->execute();

        $libro = $stmt->fetch(PDO::FETCH_OBJ);
        if ($libro) {
            $libro->id = (string)$libro->id;
            $libro->id_autor = isset($libro->id_autor) ? (string)$libro->id_autor : null;

            if (isset($libro->f_publicacion)) {
                $timestamp = strtotime($libro->f_publicacion);
                $libro->f_publicacion = date('d/m/Y', $timestamp);
            }

            return $libro;
        } else {
            return null;
        }

    } catch (PDOException $e) {
        error_log("Error de consulta: " . $e->getMessage());
        return null;
    }
}


    public function borrarAutor($pdo, $id)
    {
        try {
            $stmtLibros = $pdo->prepare("DELETE FROM Libro WHERE id_autor = :id");
            $stmtLibros->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtLibros->execute();

            $stmtAutor = $pdo->prepare("DELETE FROM Autor WHERE id = :id");
            $stmtAutor->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtAutor->execute();
            if($stmtAutor->rowCount() > 0) {
                return true;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Error al borrar autor y sus libros: " . $e->getMessage());
            return null;
        }
    }

    public function borrarLibro($pdo, $id)
    {
        try {
            $stmt = $pdo->prepare("DELETE FROM Libro WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->rowCount() > 0;

            if ($resultado) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al borrar libro: " . $e->getMessage());
            return false;
        }
    }

}
?>