<?php

require "config.php";

function listar_archivos() {
    $directorio = DIR_UPLOAD;
    $archivos = glob($directorio . "*");

    // Ordenar archivos por fecha de modificación (más antiguo primero)
    usort($archivos, function($a, $b) {
        return filemtime($a) - filemtime($b);
    });

    foreach ($archivos as $archivo) {
        if ($archivo != "." && $archivo != "..") {
            $nombreArchivo = basename($archivo);
            $rutaArchivo = $directorio . $nombreArchivo;
            $tamaño = filesize($rutaArchivo) / 1024; // Convertir bytes a kilobytes
            echo '<div class="table-row">';
            echo '<div class="table-cell first-cell">';
            echo '<a href="archivo.php?nombre=' . urlencode($nombreArchivo) . '">' . $nombreArchivo . '</a>';
            echo '</div>';
            echo '<div class="table-cell">';
            echo '<p>' . round($tamaño, 2) . ' KB</p>';
            echo '</div>';
            echo '<div class="table-cell last-cell">';
            echo '<button class="button-R-pushable" role="button" onclick="borrarArchivo(\'' . $nombreArchivo . '\')">';
            echo '<span class="button-R-shadow"></span>';
            echo '<span class="button-R-edge"></span>';
            echo '<span class="button-R-front text">Borrar</span>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de archivos</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"> 
</head>
<body>
    <div class="Subir">
        <h1>Subir Archivos</h1>
        <form id="formularioSubir" action="subir_archivo.php" method="post" enctype="multipart/form-data">
            <label for="nombre" class="input-label">Nombre del Archivo (opcional):</label>
            <input type="text" id="nombre" name="nombre" class="input-field">
            <br>
            <label for="archivo" class="input-label">Seleccionar Archivo:</label>
            <input type="file" id="archivo" name="archivo" class="input-field">
            <br>
            <input type="submit" value="Subir Archivo" class="submit-button">
        </form>
    </div>
    <div class="table-box">
        <div class="table-row table-head">
            <div class="table-cell first-cell">
                <p>Nombre del archivo</p>
            </div>
            <div class="table-cell">
                <p>Tamaño</p>
            </div>
            <div class="table-cell last-cell">
                <p>Borrar</p>
            </div> 
        </div>
        <?php listar_archivos(); ?>
    </div>
    <div class="buttonCr-R-container">
        <button id="CerrarBtn" class="buttonCr-R-pushable" role="button">
            <span class="buttonCr-R-shadow"></span>
            <span class="buttonCr-R-edge"></span>
            <span class="buttonCr-R-front text">
                Cerrar sesión
            </span>
        </button>
    </div>
    <script>
        document.getElementById("CerrarBtn").addEventListener("click", function() {
            window.location.href = "login.php";
        });
        // Obtener el formulario y añadir un listener para el evento submit
        document.getElementById('formularioSubir').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario por defecto
            
            // Crear un objeto FormData para enviar el formulario
            var formData = new FormData(this);
            
            // Realizar una petición AJAX para enviar el formulario
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'subir_archivo.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Mostrar un mensaje con la respuesta recibida
                    alert(xhr.responseText);
                    // Recargar la página para actualizar la lista de archivos
                    location.reload();
                } else {
                    alert('Error al subir el archivo.');
                }
            };
            xhr.send(formData);
        });
        function borrarArchivo(nombreArchivo) {
            if (confirm("¿Estás seguro de que deseas borrar el archivo " + nombreArchivo + "?")) {
                // Realizar una petición AJAX para eliminar el archivo
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'borrar_archivo.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Mostrar un mensaje con la respuesta recibida
                        alert(xhr.responseText);
                        // Recargar la página para actualizar la lista de archivos
                        location.reload();
                    } else {
                        alert('Error al borrar el archivo.');
                    }
                };
                xhr.send('nombre=' + encodeURIComponent(nombreArchivo));
            }
        }
    </script>
</body>
</html>
