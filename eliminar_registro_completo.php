<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['id_alumno'])){ header("Location: index.php"); exit(); }
$id_alumno = $_SESSION['id_alumno'];

// Obtener los nombres de los archivos para borrarlos de la carpeta
$query = "SELECT * FROM registro_servicio WHERE id_alumno = '$id_alumno'";
$res = mysqli_query($conexion, $query);

if($fila = mysqli_fetch_assoc($res)){
    $ruta = "uploads/servicio/";
    // Lista de columnas que pueden tener archivos
    $docs = ['doc_presentacion', 'doc_aceptacion', 'doc_informe1', 'doc_informe2', 'doc_termino', 'doc_liberacion'];

    foreach($docs as $doc){
        if(!empty($fila[$doc]) && file_exists($ruta . $fila[$doc])){
            unlink($ruta . $fila[$doc]); // Borra el archivo físico
        }
    }

    //Borrar el registro de la base de datos
    $sql_borrar = "DELETE FROM registro_servicio WHERE id_alumno = '$id_alumno'";
    
    if(mysqli_query($conexion, $sql_borrar)){
        
        //ACTUALIZACIÓN CRÍTICA: Regresar el estatus a 'Inactivo'
        $sql_update = "UPDATE alumnos SET estatus_servicio = 'Inactivo' WHERE id_alumno = '$id_alumno'";
        mysqli_query($conexion, $sql_update);
        
        header("Location: servicio_social.php?msg=Registro cancelado correctamente");
        exit();
    }
}

header("Location: servicio_social.php?error=No se pudo eliminar");
?>