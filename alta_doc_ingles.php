<?php
session_start();
if(!isset($_SESSION['id_alumno']) || !isset($_GET['doc'])){ header("Location: ingles.php"); exit(); }

$doc_solicitado = $_GET['doc'];

// Mapa de nombres
$nombres_docs = [
    'doc_colocacion' => 'Resultado Examen de Colocación',
    'doc_nivel1' => 'Constancia Nivel 1',
    'doc_nivel2' => 'Constancia Nivel 2',
    'doc_nivel3' => 'Constancia Nivel 3',
    'doc_nivel4' => 'Constancia Nivel 4',
    'doc_nivel5' => 'Constancia Nivel 5',
    'doc_liberacion' => 'Certificado de Liberación'
];

$titulo_mostrar = $nombres_docs[$doc_solicitado] ?? 'Documento de Inglés';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Documento Inglés</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .upload-card { max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid var(--rojo-edomex); text-align: center; }
        .btn-enviar { background: var(--rojo-edomex); color: white; padding: 12px; width: 100%; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 15px; }
        .btn-enviar:hover { background: #7d1d3a; }
    </style>
</head>
<body>
    <?php $subtitulo = "Carga de Archivos"; include 'includes/header.php'; ?>
    
    <div class="container">
        <?php if(isset($_GET['error'])): ?>
            <div style="background: #f8d7da; color:#721c24; padding:10px; border-radius:5px; margin: 10px auto; max-width: 500px;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="upload-card">
            <h3 style="color: var(--rojo-edomex);">Subir: <?php echo $titulo_mostrar; ?></h3>
            <p>Selecciona tu archivo PDF (Máx 2MB)</p>
            
            <form action="procesar_subida_ingles.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="tipo_doc" value="<?php echo $doc_solicitado; ?>">
                
                <input type="file" name="archivo" accept=".pdf" required style="margin: 20px 0; width: 100%; padding: 10px; border: 1px dashed #ccc;">
                
                <button type="submit" class="btn-enviar">
                    <i class="fas fa-cloud-upload-alt"></i> Guardar Archivo
                </button>
            </form>
            <br>
            <a href="ingles.php" style="color: #666; text-decoration: none;">Regresar</a>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>