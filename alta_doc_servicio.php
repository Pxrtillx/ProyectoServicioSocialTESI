<?php
session_start();
if(!isset($_SESSION['id_alumno']) || !isset($_GET['doc'])){ header("Location: servicio_social.php"); exit(); }
$doc_solicitado = $_GET['doc'];
// Mapa de títulos
$titulos = [
    'doc_presentacion' => 'Carta de Presentación',
    'doc_aceptacion' => 'Carta de Aceptación',
    'doc_informe1' => 'Informe Trimestral 1',
    'doc_informe2' => 'Informe Trimestral 2',
    'doc_termino' => 'Carta de Término',
    'doc_liberacion' => 'Constancia de Liberación'
];
$titulo_mostrar = $titulos[$doc_solicitado] ?? 'Documento';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Documento</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .upload-card { max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid var(--rojo-edomex); text-align: center; }
        .btn-enviar { background: var(--rojo-edomex); color: white; padding: 12px; width: 100%; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <?php $subtitulo = "Carga de Archivos"; include 'includes/header.php'; ?>
    <div class="container">
        <div class="upload-card">
            <h3 style="color: var(--rojo-edomex);">Subir: <?php echo $titulo_mostrar; ?></h3>
            <p>Selecciona tu archivo PDF (Máx 2MB)</p>
            
            <form action="procesar_doc_servicio.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo_doc" value="<?php echo $doc_solicitado; ?>">
                <input type="file" name="archivo" accept=".pdf" required style="margin: 15px 0;">
                <button type="submit" class="btn-enviar">Guardar Archivo</button>
            </form>
            <br>
            <a href="servicio_social.php" style="color: #666;">Regresar</a>
        </div>
    </div>
</body>
</html>