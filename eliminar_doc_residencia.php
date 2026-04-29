<?php
session_start();
include 'includes/db.php';

// Validar sesión y parámetros
if(!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])){
    header("Location: residencias.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']);

// Lista blanca de las 19 columnas de documentos_residencias para seguridad
$columnas_validas = [
    'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
    'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
    'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reporte1',
    'doc_reporte2', 'doc_reporte3', 'doc_reporte4', 'doc_reporte5',
    'doc_reporte6', 'doc_termino_empresa', 'doc_evaluacion',
    'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
];

if(in_array($tipo_doc, $columnas_validas)){
    
    // Obtener el id_residencia y el nombre del archivo mediante un JOIN
    $query = "SELECT d.$tipo_doc, r.id_residencia 
              FROM registro_residencias r
              JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
              WHERE r.id_alumno = '$id_alumno'";
    
    $res = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($res);
    
    if($fila && !empty($fila[$tipo_doc])){
        $nombre_archivo = $fila[$tipo_doc];
        $id_residencia = $fila['id_residencia'];
        $ruta_completa = "uploads/residencias/" . $nombre_archivo;
        
        // Borrar el archivo físico del servidor
        if(file_exists($ruta_completa)){
            unlink($ruta_completa);
        }

        // Borrar el registro en la base de datos (ponerlo en NULL)
        $sql_update = "UPDATE documentos_residencias 
                       SET $tipo_doc = NULL 
                       WHERE id_residencia = '$id_residencia'";
        
        if(mysqli_query($conexion, $sql_update)){
            header("Location: residencias.php?exito=Documento eliminado correctamente.");
            exit();
        } else {
            header("Location: residencias.php?error=Error al actualizar la base de datos.");
            exit();
        }
    }
}

// Redirigir por defecto si el tipo no es válido o no se encontró el archivo
header("Location: residencias.php");
exit();
?><?php
session_start();
include 'includes/db.php';

// Validar sesión y parámetros
if(!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])){
    header("Location: residencias.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']);

// Lista blanca de las 19 columnas de documentos_residencias para seguridad
$columnas_validas = [
    'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
    'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
    'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reporte1',
    'doc_reporte2', 'doc_reporte3', 'doc_reporte4', 'doc_reporte5',
    'doc_reporte6', 'doc_termino_empresa', 'doc_evaluacion',
    'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
];

if(in_array($tipo_doc, $columnas_validas)){
    
    // 1. Obtener el id_residencia y el nombre del archivo mediante un JOIN
    $query = "SELECT d.$tipo_doc, r.id_residencia 
              FROM registro_residencias r
              JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
              WHERE r.id_alumno = '$id_alumno'";
    
    $res = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($res);
    
    if($fila && !empty($fila[$tipo_doc])){
        $nombre_archivo = $fila[$tipo_doc];
        $id_residencia = $fila['id_residencia'];
        $ruta_completa = "uploads/residencias/" . $nombre_archivo;
        
        // 2. Borrar el archivo físico del servidor
        if(file_exists($ruta_completa)){
            unlink($ruta_completa);
        }

        // 3. Borrar el registro en la base de datos (ponerlo en NULL)
        $sql_update = "UPDATE documentos_residencias 
                       SET $tipo_doc = NULL 
                       WHERE id_residencia = '$id_residencia'";
        
        if(mysqli_query($conexion, $sql_update)){
            header("Location: residencias.php?exito=Documento eliminado correctamente.");
            exit();
        } else {
            header("Location: residencias.php?error=Error al actualizar la base de datos.");
            exit();
        }
    }
}

// Redirigir por defecto si el tipo no es válido o no se encontró el archivo
header("Location: residencias.php");
exit();
?><?php
session_start();
include 'includes/db.php';

// Validar sesión y parámetros
if(!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])){
    header("Location: residencias.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']);

// Lista blanca de las 19 columnas de documentos_residencias para seguridad
$columnas_validas = [
    'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
    'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
    'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reporte1',
    'doc_reporte2', 'doc_reporte3', 'doc_reporte4', 'doc_reporte5',
    'doc_reporte6', 'doc_termino_empresa', 'doc_evaluacion',
    'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
];

if(in_array($tipo_doc, $columnas_validas)){
    
    // 1. Obtener el id_residencia y el nombre del archivo mediante un JOIN
    $query = "SELECT d.$tipo_doc, r.id_residencia 
              FROM registro_residencias r
              JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
              WHERE r.id_alumno = '$id_alumno'";
    
    $res = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($res);
    
    if($fila && !empty($fila[$tipo_doc])){
        $nombre_archivo = $fila[$tipo_doc];
        $id_residencia = $fila['id_residencia'];
        $ruta_completa = "uploads/residencias/" . $nombre_archivo;
        
        // 2. Borrar el archivo físico del servidor
        if(file_exists($ruta_completa)){
            unlink($ruta_completa);
        }

        // 3. Borrar el registro en la base de datos (ponerlo en NULL)
        $sql_update = "UPDATE documentos_residencias 
                       SET $tipo_doc = NULL 
                       WHERE id_residencia = '$id_residencia'";
        
        if(mysqli_query($conexion, $sql_update)){
            header("Location: residencias.php?exito=Documento eliminado correctamente.");
            exit();
        } else {
            header("Location: residencias.php?error=Error al actualizar la base de datos.");
            exit();
        }
    }
}

// Redirigir por defecto si el tipo no es válido o no se encontró el archivo
header("Location: residencias.php");
exit();
?><?php
session_start();
include 'includes/db.php';

// Validar sesión y parámetros
if(!isset($_SESSION['id_alumno']) || !isset($_GET['tipo'])){
    header("Location: residencias.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];
$tipo_doc = mysqli_real_escape_string($conexion, $_GET['tipo']);

// Lista blanca de las 19 columnas de documentos_residencias para seguridad
$columnas_validas = [
    'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
    'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
    'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reporte1',
    'doc_reporte2', 'doc_reporte3', 'doc_reporte4', 'doc_reporte5',
    'doc_reporte6', 'doc_termino_empresa', 'doc_evaluacion',
    'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
];

if(in_array($tipo_doc, $columnas_validas)){
    
    // 1. Obtener el id_residencia y el nombre del archivo mediante un JOIN
    $query = "SELECT d.$tipo_doc, r.id_residencia 
              FROM registro_residencias r
              JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
              WHERE r.id_alumno = '$id_alumno'";
    
    $res = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($res);
    
    if($fila && !empty($fila[$tipo_doc])){
        $nombre_archivo = $fila[$tipo_doc];
        $id_residencia = $fila['id_residencia'];
        $ruta_completa = "uploads/residencias/" . $nombre_archivo;
        
        // 2. Borrar el archivo físico del servidor
        if(file_exists($ruta_completa)){
            unlink($ruta_completa);
        }

        // 3. Borrar el registro en la base de datos (ponerlo en NULL)
        $sql_update = "UPDATE documentos_residencias 
                       SET $tipo_doc = NULL 
                       WHERE id_residencia = '$id_residencia'";
        
        if(mysqli_query($conexion, $sql_update)){
            header("Location: residencias.php?exito=Documento eliminado correctamente.");
            exit();
        } else {
            header("Location: residencias.php?error=Error al actualizar la base de datos.");
            exit();
        }
    }
}

// Redirigir por defecto si el tipo no es válido o no se encontró el archivo
header("Location: residencias.php");
exit();
?>