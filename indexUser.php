<?php

require "config.php";

function listar_archivos() {
    $directorio = DIR_UPLOAD;
    $archivos = glob($directorio . "*");
    usort($archivos, function($a, $b) {
        return filemtime($a) - filemtime($b);
    });

    foreach ($archivos as $archivo) {
        if ($archivo != "." && $archivo != "..") {
            $nombreArchivo = basename($archivo);
            $rutaArchivo = $directorio . $nombreArchivo;
            $tamaño = filesize($rutaArchivo) / 1024;
            echo '<div class="table-row">';
            echo '<div class="table-cell first-cell">';
            echo '<a href="archivo.php?nombre=' . urlencode($nombreArchivo) . '">' . $nombreArchivo . '</a>';
            echo '</div>';
            echo '<div class="table-cell">';
            echo '<p>' . round($tamaño, 2) . ' KB</p>';
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
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="table-box">
        <div class="table-row table-head">
            <div class="table-cell first-cell">
                <p>Nombre del archivo</p>
            </div>
            <div class="table-cell">
                <p>Tamaño</p>
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
    </script>
</body>
</html>
