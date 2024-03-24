<?php
require "config.php";
// Verificar si se ha recibido el nombre del archivo a eliminar
if(isset($_POST['nombre'])) {
    // Directorio donde se almacenan los archivos a eliminar
    $directorio = DIR_UPLOAD;

    // Obtener el nombre del archivo a eliminar
    $nombreArchivo = $_POST['nombre'];

    // Ruta completa del archivo
    $rutaArchivo = $directorio . $nombreArchivo;

    // Verificar si el archivo existe y es posible eliminarlo
    if(file_exists($rutaArchivo)) {
        // Intentar eliminar el archivo
        if(unlink($rutaArchivo)) {
            echo 'El archivo ' . $nombreArchivo . ' ha sido eliminado exitosamente.';
        } else {
            echo 'Error al intentar eliminar el archivo ' . $nombreArchivo . '.';
        }
    } else {
        echo 'El archivo ' . $nombreArchivo . ' no existe.';
    }
} else {
    echo 'No se ha proporcionado el nombre del archivo a eliminar.';
}
?>
