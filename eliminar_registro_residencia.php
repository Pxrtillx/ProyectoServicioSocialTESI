<?php
session_start();
include 'includes/db.php';

//Verificacion de seguridad
if(!isset($_SESSION['id_alumno'])){
    header("Location: index.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];

//Obtener la info de los archivos JOIN entre dos tablas
$query = "SELECT r.id_residencia, d.* FROM registro_residencias r
            JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
            WHERE r.id_alumno = '$id_alumno'";

$res = mysqli_query($conexion, $query);

if($fila = mysqli_fetch_assoc($res)){
    $ruta = "uploads/residencias/";

    //Lista completa de documentos
    $docs = [
        'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
        'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
        'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reporte1',
        'doc_reporte2', 'doc_reporte3', 'doc_reporte4', 'doc_reporte5',
        'doc_reporte6', 'doc_termino_empresa', 'doc_evaluacion',
        'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
    ];

    //Borrado de archivos en el servidor
    foreach($docs as $doc){
        if(!empty($fila[$doc]) && file_exists($ruta . $fila[$doc])){
            unlink($ruta . $fila[$doc]);
        }
    }

    //Borrar registro de la BD
    $sql_borrar = "DELETE FROM registro_residencias WHERE id_alumno = '$id_alumno'";

    if(mysqli_query($conexion, $sql_borrar)){

        //Actualizar Estatus
        $sql_update = "UPDATE alumnos SET estatus_residencia = 'Inactivo' WHERE id_alumno = '$id_alumno'";
        mysqli_query($conexion, $sql_update);
        
        header("Location: residencias.php?exito=Registro eliminado correctamente.");
        exit();
    }else {
        header("Location: residencias.php?error=Error al eliminar el registro.");
        exit();    
    }
}

//Si no se halla ningún registro:
header("Location: residencias.php?error=No se encontró un registro activo.");

?>