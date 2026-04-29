<?php
session_start();
include 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])){
    $id_alumno = $_SESSION['id_alumno'];
    $tipo_doc = $_POST['tipo_doc']; // Ej: 'doc_informe1'
    $archivo = $_FILES['archivo'];

    // Validaciones
    if($archivo['size'] > 2097152){ header("Location: servicio_social.php?error=Muy pesado"); exit(); }
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if($ext != 'pdf'){ header("Location: servicio_social.php?error=Solo PDF"); exit(); }

    // Obtener matrícula para el nombre
    $q = mysqli_query($conexion, "SELECT matricula FROM alumnos WHERE id_alumno='$id_alumno'");
    $matricula = mysqli_fetch_assoc($q)['matricula'];

    // Guardar
    $dir = "uploads/servicio/";
    if(!file_exists($dir)) mkdir($dir, 0777, true);
    
    $nombre_final = $matricula."_". "servicio_" . $tipo_doc . "_"  . "_" . time() . ".pdf";
    
    if(move_uploaded_file($archivo['tmp_name'], $dir . $nombre_final)){
        // Actualizar la columna específica
        $sql = "UPDATE registro_servicio SET $tipo_doc = '$nombre_final' WHERE id_alumno = '$id_alumno'";
        mysqli_query($conexion, $sql);
        header("Location: servicio_social.php");
    }
}
?>