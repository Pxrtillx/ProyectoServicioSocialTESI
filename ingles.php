<?php
session_start();
include 'includes/db.php';

//Verificación de seguridad
if(!isset($_SESSION['id_alumno'])){ header("Location: index.php"); exit(); }
$id_alumno = $_SESSION['id_alumno'];

//Consulta los datos del alumno
$query = "SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'";
$res_alumno = mysqli_query($conexion, $query);
$alumno = mysqli_fetch_assoc($res_alumno);

//Datos de documentos inglés
$query_docs = "SELECT * FROM avance_ingles WHERE id_alumno = '$id_alumno'";
$res_docs = mysqli_query($conexion, $query_docs);

if(mysqli_num_rows($res_docs) > 0){
    $docs = mysqli_fetch_assoc($res_docs);
} else {
    $docs = []; 
}

$ruta = "uploads/ingles/";

//Función auxiliar para mostrar estatus
function botonesAccion($archivo, $carpeta, $tipo_doc){
    if(!empty($archivo) && file_exists($carpeta . $archivo)){
        //Si existe muestra botones
        return '
        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
            <a href="'.$carpeta.$archivo.'" target="_blank" style="color:grey; font-weight: bold; text-decoration: none;">
                <i class="fas fa-eye"></i>
            </a>
            <a href="eliminar_ingles.php?tipo='.$tipo_doc.'"
                onclick="return confirm(\'¿Seguro que quieres eliminar este archivo?\');"
                style="color: #c62828; text-decoration: none;" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
            </a>
        </div>';
    }else{
        //No existe: Boton Subir
        return '<a href="alta_doc_ingles.php?doc='.$tipo_doc.'" class="btn-subir">
                    <i class="fas fa-upload"></i> Subir PDF 
                </a>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos de Inglés</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .info-row { display: flex; justify-content: space-between; padding: 20px 0; border-bottom: 1px solid #eee; align-items: center; }
        
        /* gris oscuro (#444) para las letras */
        .label-title { font-weight: bold; color: #444; font-size: 1.05rem; }
        
        /* Clase para agrupar el título*/
        .label-group { flex: 1; }
        .text-small { display: block; color: #777; font-size: 0.85rem; margin-top: 5px; font-weight: normal; }

        .data-value { flex: 1; color: #333; text-align: right; }
        
        /* ESTILO BOTÓN SUBIR */
        .btn-subir { 
            background: var(--rojo-edomex); 
            color: white; 
            padding: 8px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-size: 0.9rem; 
            transition: 0.3s; 
            display: inline-block;
        }
        .btn-subir:hover { background: #7d1d3a; }
        
        .container { padding-bottom: 50px; }
    </style>
</head>

<body>
    <?php $subtitulo = "Informe Niveles de Inglés"; include 'includes/header.php'; ?>

    <div class="container">
        <h2 style="color: var(--rojo-edomex); border-bottom: 2px solid var(--rojo-edomex); padding-bottom: 10px; margin-top: 20px;">
            <i class="fas fa-language"></i> Control de Idiomas
        </h2>

        <div class="info-row">
            <span class="label-group label-title">Nombre del Alumno: </span>
            <span class="data-value"><?php echo $alumno['nombre']." ". $alumno['ap_paterno']." ". $alumno['ap_materno']; ?></span>
        </div>

        <div class="info-row">
            <div class="label-group">
                <span class="label-title">1. Resultado Examen de Colocación:</span>
                <span class="text-small">Sube el mismo PDF un nivel antes del resultado que hayas obtenido.</span>
            </div>
            <span class="data-value"><?php echo botonesAccion($docs['doc_colocacion'] ?? null, $ruta, 'doc_colocacion'); ?></span>
        </div>

        <div class="info-row">
            <div class="label-group">
                <span class="label-title">2. Resultado Examen de Certificación:</span>
                <span class="text-small">Sube el mismo PDF en todos los niveles si pasas el examen.</span>
            </div>
            <span class="data-value"><?php echo botonesAccion($docs['doc_certificacion'] ?? null, $ruta, 'doc_certificacion'); ?> </span>
        </div>

        <div class="info-row">
            <span class="label-group label-title">3. Constancia Nivel 1:</span>
            <span class="data-value" > <?php echo botonesAccion($docs['doc_nivel1'] ?? null, $ruta, 'doc_nivel1'); ?></span>
        </div>

        <div class="info-row">
            <span class="label-group label-title">4. Constancia Nivel 2:</span>
            <span class="data-value"><?php echo botonesAccion($docs['doc_nivel2'] ?? null, $ruta, 'doc_nivel2'); ?></span>
        </div>

        <div class="info-row">
            <span class="label-group label-title">5. Constancia Nivel 3:</span>
            <span class="data-value"><?php echo botonesAccion($docs['doc_nivel3'] ?? null, $ruta, 'doc_nivel3'); ?></span>
        </div>

        <div class="info-row">
            <span class="label-group label-title">6. Constancia Nivel 4:</span>
            <span class="data-value"><?php echo botonesAccion($docs['doc_nivel4'] ?? null, $ruta, 'doc_nivel4'); ?></span>
        </div>

        <div class="info-row">
            <span class="label-group label-title">7. Constancia Nivel 5:</span>
            <span class="data-value"><?php echo botonesAccion($docs['doc_nivel5'] ?? null, $ruta, 'doc_nivel5'); ?></span>
        </div>

        <div class="info-row">
            <div class="label-group">
                <span class="label-title">8. Constancia de Inglés:</span>
                <span class="text-small">Otorgada por Coordinación de Inglés.</span>
            </div>
            <span class="data-value"><?php echo botonesAccion($docs['doc_colocacion'] ?? null, $ruta, 'doc_colocacion'); ?></span>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>