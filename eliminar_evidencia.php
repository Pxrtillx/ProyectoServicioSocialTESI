<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['id_alumno'])) { header("Location: index.php"); exit(); }

if (isset($_GET['id'])) {
    $id_evidencia = mysqli_real_escape_string($conexion, $_GET['id']);
    $id_alumno = $_SESSION['id_alumno'];

    // 1. Consultar CATEGORÍA y NOMBRE antes de borrar
    $query = "SELECT nombre_archivo, categoria FROM evidencias_creditos WHERE id_evidencia = '$id_evidencia' AND id_alumno = '$id_alumno'";
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $archivo_a_borrar = "uploads/creditos/" . $fila['nombre_archivo'];
        $categoria = $fila['categoria']; // Guardamos si era acad, dep o cult

        // 2. Borrar archivo físico
        if (file_exists($archivo_a_borrar)) { unlink($archivo_a_borrar); }

        // 3. Borrar registro de la tabla de evidencias
        $delete_query = "DELETE FROM evidencias_creditos WHERE id_evidencia = '$id_evidencia'";
        
        if (mysqli_query($conexion, $delete_query)) {
            
            // --- NUEVO: RESTAR EL CRÉDITO EN LA TABLA ALUMNOS ---
            $columna = "";
            if($categoria == 'acad') $columna = "creditos_acad";
            if($categoria == 'dep')  $columna = "creditos_dep";
            if($categoria == 'cult') $columna = "creditos_cult";

            if($columna != ""){
                // Restamos 1, pero aseguramos que no baje de 0 (por si acaso)
                $sql_restar = "UPDATE alumnos SET $columna = GREATEST(0, $columna - 1) WHERE id_alumno = '$id_alumno'";
                mysqli_query($conexion, $sql_restar);
            }
            // ---------------------------------------------------

            header("Location: creditos_complementarios.php?msg=Eliminado");
            exit();
        }
    }
}
header("Location: creditos_complementarios.php");
?>