<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])) {
    header("Location: ingles.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']); // Ej: doc_nivel1

//Obtener nombre del archivo antes de borrar
$query = "SELECT $tipo_doc FROM avance_ingles WHERE id_alumno = '$id_alumno'";
$res = mysqli_query($conexion, $query);
$fila = mysqli_fetch_assoc($res);

if ($fila && !empty($fila[$tipo_doc])) {
    $nombre_archivo = $fila[$tipo_doc];
    $ruta_completa = "uploads/ingles/" . $nombre_archivo;

    //Borrar archivo físico
    if (file_exists($ruta_completa)) {
        unlink($ruta_completa);
    }

    //Limpiar el campo en la BD (lo ponemos como NULL o vacío)
    $update_sql = "UPDATE avance_ingles SET $tipo_doc = NULL WHERE id_alumno = '$id_alumno'";
    
    if (mysqli_query($conexion, $update_sql)) {
        header("Location: ingles.php?msg=Eliminado");
        exit();
    }
}

header("Location: ingles.php");
?>