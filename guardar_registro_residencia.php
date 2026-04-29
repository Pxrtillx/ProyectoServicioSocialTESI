<?php
session_start();
include 'includes/db.php';

//Verificacion de seguridad 
if(!isset($_SESSION['id_alumno'])){
    header("Location: index.php"); exit();
}

$id_alumno = $_SESSION['id_alumno'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Recibir y limpiar datos del formulario
    $empresa = mysqli_real_escape_string($conexion, $_POST['empresa']);
    $nombre_proyecto = mysqli_real_escape_string($conexion,$_POST['nombre_proyecto']);
    $asesor_inter = mysqli_real_escape_string($conexion, $_POST['asesor_inter']);
    $asesor_exter = mysqli_real_escape_string($conexion, $_POST['asesor_exter']);
    $asesor_metodologo = mysqli_real_escape_string($conexion, $_POST['asesor_metodologo']);
    $fecha_inicio = mysqli_real_escape_string($conexion, $_POST['fecha_inicio']);
    $fecha_termino = mysqli_real_escape_string($conexion, $_POST['fecha_termino']);

    //Verificar que no exista un registro (Evita duplicados)
    $check_query = "SELECT id_residencia FROM registro_residencias WHERE id_alumno = '$id_alumno'";
    $check_res = mysqli_query($conexion, $check_query);

    if(mysqli_num_rows($check_res) > 0){
        //Si ya hay un registro lo regresa
        header("Location: residencias.php?error=Alumno ya registrado."); exit();
    }

    //Iniciar Transaccion
    mysqli_begin_transaction($conexion);

    try{
        //Insertar los datos en la tabla de registro_residencias
        $query_registro = "INSERT INTO registro_residencias
                            (id_alumno, empresa, nombre_proyecto, asesor_interno, asesor_externo, asesor_metodologico, fecha_inicio, fecha_termino)
                            VALUES 
                            ('$id_alumno', '$empresa', '$nombre_proyecto', '$asesor_inter', '$asesor_exter', '$asesor_metodologo', '$fecha_inicio', '$fecha_termino')";

        if(!mysqli_query($conexion, $query_registro)){
            throw new Exception("Error al guardar los datos principales: " . mysqli_error($conexion));
        }

        //Obtener el ID de la residencia que se acaba de crear 
        $id_residencia = mysqli_insert_id($conexion);

        //Crear el resgistro en blanco en la tabla de documentos
        $query_docs = "REPLACE INTO documentos_residencias (id_residencia)  VALUES ('$id_residencia')";

        if(!mysqli_query($conexion, $query_docs)){
            throw new Exception("Error al crear el expediente de documentos: " . mysqli_error($conexion));
        }

        //Actualizar estatus de alumno 'En proceso'
        $query_estatus = "UPDATE alumnos SET estatus_residencia = 'En proceso' WHERE id_alumno = '$id_alumno'";

        if(!mysqli_query($conexion, $query_estatus)){
            throw new Exception("Error al crear el expediente de documentos: " . mysqli_error($conexion));
        }

        //Si sale bien confirma la transaccion
        mysqli_commit($conexion);

        //Redirigir con exito
        header("Location: residencias.php?exito=Registro guaradado correctamente."); exit();
    }catch(Exception $e){
        //Si algo falla, deshacer cualquier cambio 
        mysqli_rollback($conexion);
        $error_msg = urlencode($e->getMessage());
        header("Location: residencias.php?error=Hubo un problema al procesar el registro: $error_msg");
        exit();
    }
}else {
    header("Location: residencias.php");
    exit();
}
?>