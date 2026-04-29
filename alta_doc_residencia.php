<?php
session_start();
include 'includes/db.php';

//Verificacion de Sesion
if(!isset($_SESSION['id_alumno'])){ header("Location: index.php"); exit(); }

$id_alumno = $_SESSION['id_alumno'];

//Validar que se haya enviado el parámetro 'doc' por URL
if(!isset($_GET['doc'])){
    header("Location: residencias.php?error=No se especificó ningún documento."); exit(); }

$tipo_doc = $_GET['doc'];

//Lista de documentos permitidos
$documentos_permitidos = [
    'doc_soli_carta_pre', 'doc_carta_presentacion', 'doc_aceptacion',
    'doc_propuesta_antepro', 'doc_caratula_antepro', 'doc_carta_asesor_inter',
    'doc_carta_asesor_exter', 'doc_carta_asesor_metodo', 'doc_reportes_mensuales', 'doc_termino_empresa', 'doc_evaluacion', 
    'doc_checklist', 'doc_caratula_proyecto', 'doc_termino_final'
];

//Si se intenta alterar la URL con algo que  o existe
if(!in_array($tipo_doc, $documentos_permitidos)){
    header("Location: residencias.php?=error=Tipo de documento inválido.");
    exit();
}

//Obtener datos del alumno y de su registro de residencia activo
$query_info = "SELECT a.matricula, r.id_residencia
                FROM alumnos a
                JOIN registro_residencias r ON a.id_alumno = r.id_alumno
                WHERE a.id_alumno = '$id_alumno'";
$res_info = mysqli_query($conexion, $query_info);

if(mysqli_num_rows($res_info) == 0){
    header("Location: residencias.php?error=No tienes un registro de residencias activo.");
    exit();
}

$info = mysqli_fetch_assoc($res_info);
$matricula = $info['matricula'];
$id_residencia = $info['id_residencia'];

//Mapeo de títulos
$nombres_amigables = [
    'doc_soli_carta_pre' => 'Solicitud de Carta de Presentación',
    'doc_carta_presentacion' => 'Carta de Presentación Oficial',
    'doc_aceptacion' => 'Carta de Aceptación de la Empresa',
    'doc_propuesta_antepro' => 'Propuesta de Anteproyecto',
    'doc_caratula_antepro' => 'Carátula de Anteproyecto',
    'doc_carta_asesor_inter' => 'Asignación Asesor Interno',
    'doc_carta_asesor_exter' => 'Asignación Asesor Externo',
    'doc_carta_asesor_metodo' => 'Asignación Asesor Metodológico',
    'doc_reportes_mensuales' => 'Reportes Mensuales',
    'doc_termino_empresa' => 'Carta de Término (Emitida por la Empresa)',
    'doc_evaluacion' => 'Rúbrica de Evaluación Final',
    'doc_checklist' => 'Checklist de Revisión',
    'doc_caratula_proyecto' => 'Carátula de Proyecto Final',
    'doc_termino_final' => 'Carta de Liberación Final (Oficial)'
];
$titulo_visual = $nombres_amigables[$tipo_doc];

//Procesamiento del formulario POST 
$error = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == UPLOAD_ERR_OK){

        $nombre_temp = $_FILES['archivo_pdf']['tmp_name'];
        $nombre_original = $_FILES['archivo_pdf']['name'];
        $tamano = $_FILES['archivo_pdf']['size'];

        //extraer la extension y forzar minusculas
        $ext = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

        //Validaciones
        if($ext !== 'pdf'){
            $error = "El archivo debe ser PDF.";
        }elseif ($tamano > 2000000){ //Limite de 2MB
            $error = "El archivo es demasiado pesado. Máximo 2MB";
        }else{
            //Crear nombre único de archivo
            $nombre_final = $matricula . "_" . $tipo_doc . "_" . time() . ".pdf";
            $ruta_destino = "uploads/residencias/" . $nombre_final;

            //Subir al Servidor
            if(move_uploaded_file($nombre_temp, $ruta_destino)){

                //Actualizar UNICAMENTE la columna correspondiente al doc subido
                $query_update = "UPDATE documentos_residencias
                                SET $tipo_doc = '$nombre_final'
                                WHERE id_residencia = '$id_residencia'";
                if(mysqli_query($conexion, $query_update)){
                    header("Location: residencias.php?exito=Documento guardado correctamente.");
                    exit();
                }else{
                    $error = "Hubo un error al guardar el archivo en el servidor.";
                }
            }
        }
    }else{
        $error = "Por favor selecciona un archivo válido";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Documento - Residencias</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .upload-card {
            background: white; max-width: 600px; margin: 50px auto;
            padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 5px solid var(--rojo-edomex);
        }
        .upload-title { text-align: center; color: #333; margin-bottom: 5px; }
        .upload-subtitle { text-align: center; color: var(--rojo-edomex); font-size: 1.2rem; font-weight: bold; margin-bottom: 25px; }
        
        .file-drop-area {
            border: 2px dashed #ccc; border-radius: 8px; padding: 40px 20px;
            text-align: center; background: #fafafa; margin-bottom: 20px; transition: 0.3s;
        }
        .file-drop-area:hover { background: #f0f0f0; border-color: var(--oro-edomex); }
        .file-drop-area i { font-size: 3rem; color: #999; margin-bottom: 15px; }
        .file-drop-area input[type="file"] { margin-top: 15px; }

        .btn-submit {
            background: var(--rojo-edomex); color: white; border: none;
            padding: 12px; width: 100%; font-size: 1.1rem; border-radius: 5px;
            cursor: pointer; font-weight: bold; transition: 0.3s;
        }
        .btn-submit:hover { background: #7d1d3a; }
        
        .alert-error {
            background-color: #fdf2f2; border: 1px solid #f8b4b4; color: #9b1c1c;
            padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.95rem;
        }
    </style>
</head>
<body style="background-color: #eef2f6;">
    <div class="header-gob"></div>
    <header>
        <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3>Residencias Profesionales</h3>
    </header>

    <div class="container">
        <div class="upload-card">
            
            <div style="text-align: left; margin-bottom: 20px;">
                <a href="residencias.php" style="color: #666; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>

            <h2 class="upload-title">Subir Documento</h2>
            <div class="upload-subtitle"><?php echo $titulo_visual; ?></div>

            <?php if(!empty($error)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="file-drop-area">
                    <i class="fas fa-file-pdf"></i>
                    <p style="margin: 0; color: #555;">Selecciona tu archivo en formato PDF</p>
                    <p style="margin: 5px 0 0 0; font-size: 0.8rem; color: #999;">(Tamaño máximo: 2MB)</p>
                    
                    <input type="file" name="archivo_pdf" accept=".pdf" required style="max-width: 100%;">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-cloud-upload-alt"></i> SUBIR ARCHIVO
                </button>
            </form>
            
        </div>
    </div>
            <?php include 'includes/footer.php'; ?>
</body>
</html>