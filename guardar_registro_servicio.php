<?php 
session_start();
include 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id_alumno'])){
    $id_alumno = $_SESSION['id_alumno'];

    //Nombre de empresa 
    $empresa = mysqli_real_escape_string($conexion, $_POST['empresa']);
    $responsable = mysqli_real_escape_string($conexion, $_POST['responsable']);
    $area = mysqli_real_escape_string($conexion, $_POST['area_desempeno']);
    //Recibir fechas 
    $inicio = $_POST['fecha_inicio'];
    $termino = $_POST['fecha_termino'];

    $sql_insert = "INSERT INTO registro_servicio (id_alumno, empresa, responsable, area_desempeno, fecha_inicio, fecha_termino)
            VALUES ('$id_alumno', '$empresa', '$responsable', '$area', '$inicio', '$termino')";
    
    if(mysqli_query($conexion, $sql_insert)){

        //Actualizamos el estatus del alumno 
        $sql_update = "UPDATE alumnos SET estatus_servicio = 'En proceso' WHERE id_alumno = '$id_alumno'";
        mysqli_query($conexion, $sql_update);
        
        //Redirección al panel con éxito
        header("Location: servicio_social.php");
        exit();
    }else{
        echo "Error al guardar los datos: ". mysqli_error($conexion);
    }
}else {
    //Si intentan entrar directo sin guardar datos
    header("Location: servicio_social.php");
    exit();
}
?>