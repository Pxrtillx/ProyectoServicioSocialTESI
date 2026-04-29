<?php
session_start();
include 'includes/db.php';

// Verificación de seguridad básica
if(!isset($_SESSION['id_alumno'])){ 
    header("Location: index.php"); 
    exit(); 
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])){

    $id_alumno = $_SESSION['id_alumno'];

    // --- 1. VALIDACIÓN CRÍTICA: Límite de 5 créditos ---
    $query_conteo = "SELECT COUNT(*) as total FROM evidencias_creditos WHERE id_alumno = '$id_alumno'";
    $res_conteo = mysqli_query($conexion, $query_conteo);
    $row_conteo = mysqli_fetch_assoc($res_conteo);
    
    if($row_conteo['total'] >= 5){
        // Si ya tiene 5 o más, se bloquea la subida y se regresa con error
        header("Location: creditos_complementarios.php?error=Ya has alcanzado el límite máximo de 5 créditos.");
        exit();
    }
    // ---------------------------------------------------

    $categoria = $_POST['categoria']; // 'acad', 'dep', 'cult'
    $archivo = $_FILES['archivo'];

    // Obtener Matrícula
    $q_mat = mysqli_query($conexion, "SELECT matricula FROM alumnos WHERE id_alumno = '$id_alumno'");
    $d_mat = mysqli_fetch_assoc($q_mat);
    $matricula = $d_mat['matricula'];

    // Validaciones
    if($archivo['size'] > 2097152){ header("Location: alta_creditos.php?error=Excede 2MB"); exit(); }
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if($ext != 'pdf'){ header("Location: alta_creditos.php?error=Solo PDF"); exit(); }

    // Guardar Archivo Físico
    $dir = "uploads/creditos/";
    if(!file_exists($dir)) mkdir($dir, 0777, true);

    // Nombre único del archivo
    $nombre_final = $matricula. "_". "credito_" . $categoria . "_" .time() . ".pdf";
    
    if(move_uploaded_file($archivo['tmp_name'], $dir . $nombre_final)){
        
        // Insertar en la tabla de historial (evidencias_creditos)
        $sql_insert = "INSERT INTO evidencias_creditos (id_alumno, categoria, nombre_archivo) VALUES ('$id_alumno', '$categoria', '$nombre_final')";
        mysqli_query($conexion, $sql_insert);

        // Determinar qué columna sumar en la tabla 'alumnos'
        $columna_a_sumar = "";
        if($categoria == 'acad') $columna_a_sumar = "creditos_acad";
        if($categoria == 'dep')  $columna_a_sumar = "creditos_dep";
        if($categoria == 'cult') $columna_a_sumar = "creditos_cult";

        // C) Actualizar contador: SUMAR 1 al valor actual
        if($columna_a_sumar != ""){
            // Aquí está la magia: campo = campo + 1
            $sql_update = "UPDATE alumnos SET $columna_a_sumar = $columna_a_sumar + 1 WHERE id_alumno = '$id_alumno'";
            
            if(mysqli_query($conexion, $sql_update)){
                header("Location: creditos_complementarios.php");
                exit();
            } else {
                echo "Error actualizando contador: " . mysqli_error($conexion);
            }
        }

    } else {
        header("Location: alta_creditos.php?error=Error al mover archivo");
    }
}
?>