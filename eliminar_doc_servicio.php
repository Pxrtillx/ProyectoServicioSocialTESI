<?php
session_start();
include 'includes/db.php';

// Validar sesión y parámetros
if(!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])){
    header("Location: servicio_social.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']); // Ej: doc_informe1

// Lista blanca de columnas permitidas para seguridad (evitar inyección SQL)
$columnas_validas = ['doc_presentacion', 'doc_aceptacion', 'doc_informe1', 'doc_informe2', 'doc_termino', 'doc_liberacion'];

if(in_array($tipo_doc, $columnas_validas)){
    
    // 1. Obtener nombre del archivo
    $query = "SELECT $tipo_doc FROM registro_servicio WHERE id_alumno = '$id_alumno'";
    $res = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($res);
    
    if($fila && !empty($fila[$tipo_doc])){
        $archivo = "uploads/servicio/" . $fila[$tipo_doc];
        
        // 2. Borrar físico
        if(file_exists($archivo)){
            unlink($archivo);
        }

        // 3. Borrar de BD (NULL)
        $sql_update = "UPDATE registro_servicio SET $tipo_doc = NULL WHERE id_alumno = '$id_alumno'";
        mysqli_query($conexion, $sql_update);
    }
}

// Redirigir siempre al panel
header("Location: servicio_social.php");
?>