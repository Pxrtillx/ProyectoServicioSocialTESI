<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['id_alumno'])){header("Location: index.php"); exit();}
$id_alumno = $_SESSION['id_alumno'];

// DATOS DEL ALUMNO Y ESTATUS GENERALES
$query = "SELECT a.*, i.doc_liberacion as ingles_liberado 
          FROM alumnos a 
          LEFT JOIN avance_ingles i ON a.id_alumno = i.id_alumno 
          WHERE a.id_alumno ='$id_alumno'";
$res_alumno = mysqli_query($conexion, $query);
$alumno = mysqli_fetch_assoc($res_alumno);

// CÁLCULO DEL SEMESTRE
$matricula = $alumno['matricula'];
$anio_ingreso = intval(substr($matricula, 0, 4));
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n"));

$diferencia_anios = $anio_actual - $anio_ingreso;
$semestre_calculado = $diferencia_anios * 2;

if($mes_actual < 3){
    $semestre_calculado--;
} elseif ($mes_actual >= 9){
    $semestre_calculado++;
}
if($semestre_calculado < 1) $semestre_calculado = 1;

// Conteo de evidencias totales
$query_creditos = "SELECT COUNT(*) as total_evidencias FROM evidencias_creditos WHERE id_alumno = '$id_alumno'";
$res_creditos = mysqli_query($conexion, $query_creditos);
$row_creditos = mysqli_fetch_assoc($res_creditos);

//Se guarda el total en una variable
$total_creditos = $row_creditos['total_evidencias'];

//Validar si tiene 5 o mas
$cumple_creditos = ($total_creditos >= 5);

// VALIDACIÓN DE REQUISITOS PARA RESIDENCIAS
$cumple_semestre = ($semestre_calculado >= 9);
$cumple_servicio = ($alumno['estatus_servicio'] == 'Liberado');
$cumple_ingles   = (!empty($alumno['ingles_liberado']));

$puede_ver_contenido = ($cumple_semestre && $cumple_servicio && $cumple_ingles && $cumple_creditos);

// VERIFICAR REGISTRO DE RESIDENCIA Y TRAER DOCUMENTOS (USANDO JOIN)
$query_residencia = "
    SELECT r.*, d.* FROM registro_residencias r 
    LEFT JOIN documentos_residencias d ON r.id_residencia = d.id_residencia 
    WHERE r.id_alumno = '$id_alumno'
";
$res_registro = mysqli_query($conexion, $query_residencia);
$tiene_registro = mysqli_num_rows($res_registro);
$datos_residencia = mysqli_fetch_assoc($res_registro);

if($tiene_registro) $puede_ver_contenido = true;

// FUNCION PARA MOSTRAR BOTONES DE DOCUMENTOS
function botonesAccion($archivo, $carpeta, $tipo_doc){
    if(!empty($archivo) && file_exists($carpeta . $archivo)){
        return '<div style="text-align: right;">
                    <a href="'.$carpeta.$archivo.'" target="_blank" style="color: grey; font-weight: bold; margin-right: 10px; text-decoration:none;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="eliminar_doc_residencia.php?tipo='.$tipo_doc.'" onclick="return confirm(\'¿Seguro que deseas eliminar este archivo?\')" style="color: #c62828;">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Residencias Profesionales</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .info-row{ display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee; align-items: center; }
        .label-title{ font-weight: bold; color: var(--rojo-edomex); flex:1; }
        .data-value{ flex: 2; color: #333; }
        
        .form-card { background: #fdfdfd; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; margin-top: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: bold; margin-bottom: 8px; color: var(--rojo-edomex); }
        .form-control { width: 95%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; }

        .req-item { display: flex; align-items: center; gap: 15px; padding: 15px; border-radius: 8px; margin-bottom: 10px; background: #f9f9f9; border: 1px solid #eee; }
        .req-check { font-size: 1.5rem; }
        .check-ok { color: #2e7d32; }
        .check-no { color: #c62828; }
        .badge-semestre { background: #eee; padding: 5px 10px; border-radius: 4px; font-weight: bold; color: #333; }

        .alert-success { background-color: #e8f5e9; border: 1px solid #c8e6c9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
        .alert-error { background-color: #fdf2f2; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }

        /* Estilos Documentos */
        .doc-item { background: #fff; padding: 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .doc-info { flex: 1; }
        .doc-title { font-weight: bold; font-size: 1.05rem; display: block; color: #333; }
        .doc-desc { font-size: 0.9rem; color: #666; display: block; margin-top: 4px; }
        .btn-subir { background: var(--rojo-edomex); color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: 0.3s; }
        .btn-subir:hover { background:#7d1d3a; }
        .fase-titulo { background: #333; color: white; padding: 10px 15px; border-radius: 5px 5px 0 0; margin-top: 30px; font-size: 1.1rem; }

        /* --- ESTILOS DE NOTIFICACIÓN ACORDEÓN --- */
        .notificacion-box {
            background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; margin: 20px 0; overflow: hidden;
        }
        .notificacion-summary {
            background: #ffc107; color: #856404; padding: 12px 20px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 1.05rem;
        }
        .notificacion-summary:hover { background: #e0a800; }
        .notificacion-content {
            padding: 20px; color: #856404; font-size: 0.95rem; line-height: 1.6; background: #fffcf5;
        }

        /* --- ESTILOS PARA PANTALLA DE ÉXITO (LIBERADO) --- */
        .card-liberado { background: white; border-radius: 15px; padding: 50px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-top: 30px; border-top: 6px solid #2e7d32; }
        .icon-success { font-size: 5rem; color: #2e7d32; margin-bottom: 20px; }
        .text-success { color: #2e7d32; font-size: 2rem; font-weight: bold; margin: 0; }
        .text-desc { color: #555; font-size: 1.1rem; margin-top: 10px; }
        .btn-download-final { display: inline-block; background: #2e7d32; color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; margin-top: 30px; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3); transition: transform 0.2s; }
        .btn-download-final:hover { transform: translateY(-3px); background: #1b5e20; }
    </style>
</head>
<body>
    <?php $subtitulo = "Residencias Profesionales"; include 'includes/header.php'; ?>

    <div class="container">

        <?php if(isset($_GET['exito'])): ?>
            <div class="alert-success">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                <?php echo htmlspecialchars($_GET['exito']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle" style="font-size:  1.2rem;"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="info-row">
            <span class="label-title">Nombre del Alumno:</span>
            <span class="data-value"><?php echo $alumno['nombre']." ".$alumno['ap_paterno']. " ". $alumno['ap_materno']; ?></span>
        </div>
        <div class="info-row">
            <span class="label-title">Semestre Actual:</span>
            <span class="data-value">
                <span class="badge-semestre"><?php echo $semestre_calculado; ?>º Semestre</span>
            </span>
        </div>

        <?php if(isset($alumno['estatus_residencia']) && $alumno['estatus_residencia'] == 'Observaciones' && !empty($datos_residencia['observaciones'])): ?>
            <details class="notificacion-box">
                <summary class="notificacion-summary">
                    <i class="fas fa-bell" style="animation: swing 2s infinite;"></i> 
                        ¡Tienes una notificación del Administrador! (Clic para ver)
                </summary>
                <div class="notificacion-content">
                    <strong>Motivo de las observaciones:</strong><br>
                    <?php echo nl2br(htmlspecialchars($datos_residencia['observaciones'])); ?>
                </div>
            </details>
        <?php endif; ?>

        <?php if(!$puede_ver_contenido): ?>
            <div class="form-card">
                <h3 style="text-align: center; color: #c62828; margin-bottom: 25px;">Requerimientos Necesarios</h3>
                <div class="req-item"><div class="req-check <?php echo $cumple_semestre ? 'check-ok' : 'check-no'; ?>"><i class="fas <?php echo $cumple_semestre ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></div><div><strong>Semestre Requerido:</strong> 9° Semestre.</div></div>
                <div class="req-item"><div class="req-check <?php echo $cumple_servicio ? 'check-ok' : 'check-no'; ?>"><i class="fas <?php echo $cumple_servicio ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></div><div><strong>Servicio Social:</strong> Liberado.</div></div>
                <div class="req-item"><div class="req-check <?php echo $cumple_ingles ? 'check-ok' : 'check-no'; ?>"><i class="fas <?php echo $cumple_ingles ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></div><div><strong>Inglés:</strong> Cargar el certificado de liberación.</div></div>
                <div class="req-item"><div class="req-check <?php echo $cumple_creditos ? 'check-ok' : 'check-no'; ?>"><i class="fas <?php echo $cumple_creditos ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i></div><div><strong>Créditos Complementarios:</strong> Completados.</div></div>
                <p style="text-align: center; margin-top: 20px; color: #666; font-style: italic;">* Cumple con todos los requisitos para habilitar el registro de Residencias. *</p>
                <div style="margin-top: 30px; text-align: center;"><a href="menu_principal.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;"><i class="fas fa-arrow-left"></i> Regresar</a></div>
            </div>

        <?php elseif(isset($alumno['estatus_residencia']) && $alumno['estatus_residencia'] == 'Liberado'): ?>
            <div class="card-liberado">
                <i class="fas fa-check-circle icon-success"></i>
                <h2 class="text-success">¡Residencias Profesionales Liberadas!</h2>
                <p class="text-desc">
                    Felicidades, has concluido satisfactoriamente tu proceso de Residencias Profesionales.
                    <br>Tu expediente ha sido revisado y aprobado por la división académica.
                </p>

                <?php if(!empty($datos_residencia['doc_termino_final'])): ?>
                    <a href="uploads/residencias/<?php echo $datos_residencia['doc_termino_final']; ?>" target="_blank" class="btn-download-final">
                        <i class="fas fa-file-pdf"></i> Descargar Carta de Liberación
                    </a>
                <?php else: ?>
                    <p style="margin-top: 20px; color: #999; font-style: italic">
                        (Tu constancia digital estará disponible aquí en breve)
                    </p>
                <?php endif; ?>

                <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="menu_principal.php" style="color: #666; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Regresar al Menú Principal
                    </a>
                </div>
            </div>

        <?php elseif(!$tiene_registro): ?>
            <div class="form-card">
                <h3 style="color: #333; border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-bottom: 20px;"><i class="fas fa-edit"></i> Registro de Residencia Profesional</h3>
                <form action="guardar_registro_residencia.php" method="POST">
                    <div class="form-group"><label class="form-label">Empresa / Institución:</label><input type="text" name="empresa" class="form-control" placeholder="Nombre de la empresa SIN abreviaturas" required></div>
                    <div class="form-group"><label class="form-label">Nombre del Proyecto:</label><input type="text" name="nombre_proyecto" class="form-control" placeholder="Nombre del proyecto de residencia" required></div>
                    <div class="form-group"><label class="form-label">Asesor Interno:</label><input type="text" name ="asesor_inter" class="form-control" placeholder="Nombre Completo del Asesor Interno" required></div>
                    <div class="form-group"><label class="form-label">Asesor Externo:</label><input type="text" name="asesor_exter" class="form-control" placeholder="Nombre Completo del Asesor Externo" required></div>
                    <div class="form-group"><label class="form-label">Asesor Metodológico:</label><input type="text" name="asesor_metodologo" class="form-control" placeholder="Nombre del Asesor Metodológico"required></div>
                    <div style="display: flex; gap: 20px;">
                        <div class="form-group" style="flex:1;"><label class="form-label">Fecha de Inicio:</label><input type="date" name="fecha_inicio" class="form-control" required></div>
                        <div class="form-group" style="flex:1;"><label class="form-label">Fecha de Término:</label><input type="date" name="fecha_termino" class="form-control" required></div>
                    </div>
                    <button type="submit" style="background: var(--rojo-edomex); color: white; border: none; padding: 15px; font-weight: bold; border-radius: 5px; cursor: pointer; width: 100%; font-size: 1.1rem;">CONFIRMAR REGISTRO</button>
                </form>
            </div>

        <?php else: ?>
            <div style="background: #fcfcfc; padding: 25px; border: 1px solid #ddd; border-left: 5px solid var(--oro-edomex); margin: 20px 0; border-radius: 5px;">
                <h3 style="margin: 0 0 10px 0; color: #333;"><?php echo $datos_residencia['empresa']; ?></h3>
                <p style="margin: 0; color: #666; line-height: 1.8;">
                    <strong>Nombre del Proyecto:</strong> <?php echo $datos_residencia['nombre_proyecto']; ?> <br>
                    <strong>Asesor Interno:</strong> <?php echo $datos_residencia['asesor_interno']; ?> <br>
                    <strong>Asesor Externo:</strong> <?php echo $datos_residencia['asesor_externo']; ?> <br>
                    <strong>Asesor Metodológico:</strong> <?php echo $datos_residencia['asesor_metodologico']; ?> <br>
                    <strong>Periodo:</strong> <?php echo date('d/m/Y', strtotime($datos_residencia['fecha_inicio'])); ?> al <?php echo date('d/m/Y', strtotime($datos_residencia['fecha_termino'])); ?>
                </p>
            </div>
            
            <h3 style="color: var(--rojo-edomex); margin-top: 30px;">Documentación Requerida</h3>
            <p style="color: #555;">Sube los archivos en formato PDF.</p>

            <?php 
            $ruta_res = "uploads/residencias/";
            
            // Array estructurado para generar los 19 documentos de forma limpia
            $fases_documentos = [
                "Fase 1: Trámites Iniciales" => [
                    "doc_soli_carta_pre" => ["1. Solicitud Carta Presentación", "Sellado y firmado por el Depto. de Gestión Tecnológica."],
                    "doc_carta_presentacion" => ["2. Carta de Presentación", "Documento que expide el Depto. de Residencia Profesional."],
                    "doc_aceptacion" => ["3. Carta de Aceptación", "Documento emitido por la empresa."]
                ],
                "Fase 2: Anteproyecto y Asignaciones" => [
                    "doc_propuesta_antepro" => ["4. Propuesta de Anteproyecto", "Descargar el formato en la página del TESI."],
                    "doc_caratula_antepro" => ["5. Carátula de Anteproyecto", "Descargar el formato en la página del TESI."],
                    "doc_carta_asesor_inter" => ["6. Carta Asesor Interno", "Carta Compromiso Asesor Interno."],
                    "doc_carta_asesor_exter" => ["7. Carta Asesor Externo", "Carta Compromiso Asesor Externo."],
                    "doc_carta_asesor_metodo" => ["8. Carta Asesor Metodológico", "Carta Compromiso Asesor Metodológico."]
                ],
                "Fase 3: Reportes Mensuales" => [
                    "doc_reportes_mensuales" => ["9. Reportes Mensuales ", "Adjunta TODOS los reportes mensuales en un PDF."]
                ],
                "Fase 4: Finalización y Liberación" => [
                    "doc_termino_empresa" => ["10. Carta de Término", "Emitida por la empresa al concluir las horas de Residencia."],
                    "doc_evaluacion" => ["11. Evaluación de Residencia", "Descargar el formato en la página del TESI."],
                    "doc_checklist" => ["12. Checklist de Revisión", "Descargar el fomato en la página del TESI."],
                    "doc_caratula_proyecto" => ["13. Carátula del Proyecto", "Descargar el formato en la página del TESI."],
                    "doc_termino_final" => ["14. Carta de Liberación de Residencia Profesional", "Doc. que emite el Depto. de Residencia Profesional"]
                ]
            ];
            
            // Generador automático de la interfaz de documentos
            foreach($fases_documentos as $nombre_fase => $documentos){
                echo "<div class='fase-titulo'><i class='fas fa-folder-open'></i> $nombre_fase</div>";
                echo "<div style='border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;'>";
                
                foreach($documentos as $columna_db => $detalles){
                    $titulo = $detalles[0];
                    $descripcion = $detalles[1];
                    $archivo_guardado = $datos_residencia[$columna_db] ?? null;
                    
                    ?>
                    <div class="doc-item">
                        <div class="doc-info">
                            <span class="doc-title"><?php echo $titulo; ?></span>
                            <span class="doc-desc"><?php echo $descripcion; ?></span>
                        </div>
                        <div class="doc-actions">
                            <?php echo botonesAccion($archivo_guardado, $ruta_res, $columna_db); ?>
                            <?php if(empty($archivo_guardado)): ?>
                                <a href="alta_doc_residencia.php?doc=<?php echo $columna_db; ?>" class="btn-subir">
                                    <i class="fas fa-upload"></i> Subir PDF
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            }
            ?>
            
            <div style="background: #fff3f3; padding: 15px; border: 1px solid #ffcdd2; border-radius: 5px; margin-top: 40px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #c62828;">¿Hubo un error en el registro?</strong>
                    <p style="margin: 0; font-size: 0.9rem; color: #555;">Si la fecha, la empresa o los nombres son incorrectos, puedes eliminar todo el registro.
                    <br>
                    <em style="font-size: 0.8rem;">(Nota: Esto borrará todos los archivos que hayas subido)</em>
                    </p>
                </div>
                <a href="eliminar_registro_residencia.php" onclick="return confirm('¡CUIDADO! \nEsto borrará TODOS tus datos y documentos. \n\n¿Estás seguro?')" style="background: #c62828; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                   <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        <?php endif; ?>

    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>