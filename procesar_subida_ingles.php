<?php
session_start();
include 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])){

    $id_alumno = $_SESSION['id_alumno'];
    $tipo_doc = $_POST['tipo_doc'];
    $archivo = $_FILES['archivo'];

    //Obtener matricula para nombre del archivo
    $query_mat = "SELECT matricula FROM alumnos WHERE id_alumno = '$id_alumno'";
    $res_mat = mysqli_query($conexion, $query_mat);
    $datos_alumno = mysqli_fetch_assoc($res_mat);
    $matricula = $datos_alumno['matricula'];

    //1. validación (pdf-tamaño)
    if($archivo['size'] > 2097152){ //2MB
        header("Location: alta_ingles.php?error=El archivo excede los 2MB"); exit();
    }
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if($ext != 'pdf'){
        header("Location: alta_ingles.php?error=Solo se admiten archivos .PDF"); exit();
    }
    //2. Preparar Carpeta y Nombre

    $directorio = "uploads/ingles/";
    if(!file_exists($directorio)) mkdir($directorio, 0777, true);
    //Nombre doc
    $nombre_final = $matricula."_"."ingles_". $tipo_doc . "_" . time(). ".pdf";
    $ruta_destino = $directorio . $nombre_final;

    if(move_uploaded_file($archivo['tmp_name'], $ruta_destino)){

        //Guardar en BD
        //Primero verifica si ya existe un registro para este alumno
        $check_query = "SELECT id_avance FROM avance_ingles WHERE id_alumno = '$id_alumno'";
        $check = mysqli_query($conexion, $check_query);

        if(mysqli_num_rows($check) > 0){
            //Si existe actualizamos la columna especifica
            $sql = "UPDATE avance_ingles SET $tipo_doc = '$nombre_final' WHERE id_alumno = '$id_alumno'";
        }else {
            //Creamos el registro insertando en la columna especifica,  si no existe
            $sql = "INSERT INTO avance_ingles (id_alumno, $tipo_doc) VALUES ('$id_alumno','$nombre_final')";
        }

        if(mysqli_query($conexion, $sql)){
            header("Location:ingles.php"); //Éxito
            exit();
        }else{
            header("Location: alta_ingles.php?error=Error de BD");
            exit();
        }
    }else{
        header("Location:alta_ingles.php?error=Error al mover el archivo");
        exit();
    }
}
?>