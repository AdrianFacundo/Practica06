<?php

require "config.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre del archivo especificado por el usuario (si lo hay)
    $nombre_personalizado = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    
    // Obtener la información del archivo subido
    $archivo_nombre = $_FILES['archivo']['name'];
    $archivo_tipo = $_FILES['archivo']['type'];
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $archivo_error = $_FILES['archivo']['error'];
    
    // Directorio donde se guardarán los archivos subidos
    $directorio_destino = DIR_UPLOAD;
    
    // Validar que el archivo tenga una extensión permitida
    $extensiones_permitidas = array("jpg", "jpeg", "png", "gif", "pdf");
    $archivo_extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));
    
    if (!in_array($archivo_extension, $extensiones_permitidas)) {
        echo "Error: Solo se permiten archivos de imagen (jpg, jpeg, png, gif) y archivos PDF.";
        exit();
    }
    
    // Si no se especifica un nombre personalizado, utilizar el nombre original del archivo
    if (!$nombre_personalizado) {
        $nombre_personalizado = pathinfo($archivo_nombre, PATHINFO_FILENAME);
    }
    
    // Concatenar la extensión del archivo original
    $nombre_personalizado_con_extension = $nombre_personalizado . '.' . $archivo_extension;
    
    // Mover el archivo subido al directorio de destino
    $ruta_destino = $directorio_destino . $nombre_personalizado_con_extension;
    if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
        echo "El archivo se ha subido correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "Error: El formulario no se ha enviado correctamente.";
}
?>
