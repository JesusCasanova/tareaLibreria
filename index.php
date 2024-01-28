<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores y Libros</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Lista de Autores y sus Libros</h1>
    <?php
    require_once './libros.php';

    $libros = new libros();
    $conexion = $libros->conexion('localhost', 'id21820522_libros', 'id21820522_jesuscasanova', 'Jesus123.');

    if ($conexion) {
        $autores = $libros->consultarAutores($conexion);
        if ($autores) {
            foreach ($autores as $autor) {
                echo "<h2>{$autor->nombre} {$autor->apellidos} - {$autor->nacionalidad}</h2>";
                $librosAutor = $libros->consultarLibros($conexion, $autor->id);
                if ($librosAutor) {
                    echo "<ul>";
                    foreach ($librosAutor as $libro) {
                        echo "<li>{$libro->titulo} (Publicado en {$libro->f_publicacion})</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron libros para este autor.</p>";
                }
            }
        } else {
            echo "<p>No se pudieron cargar los datos de los autores.</p>";
        }
    } else {
        echo "<p>Error al conectar con la base de datos.</p>";
    }
    ?>
</body>

</html>