<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['id_alumno'])){header("Location: index.php"); exit();}
$id_alumno = $_SESSION['id_alumno'];

//Datos del alumno
$query = "SELECT * FROM alumnos WHERE id_alumno ='$id_alumno'";
$res_alumno = mysqli_query($conexion, $query);
$alumno = mysqli_fetch_assoc($res_alumno);

//Calcular el semestre del alumno
$matricula = $alumno['matricula'];
$anio_ingreso = intval(substr($matricula, 0, 4)); //Primeros 4 digitos
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n")); //Mes del 1 al 12

//Calculo base por años
$diferencia_anios = $anio_actual - $anio_ingreso;
$semestre_calculado = $diferencia_anios * 2;

//2. Ajuste por mes (Meses de inicio de ciclo)
if($mes_actual <3){
    //Ene-Feb: Aún no inicia ciclo par (2°, 4°, 6°, 8°) restamos 1
    $semestre_calculado = $semestre_calculado - 1;
}elseif ($mes_actual >= 9){
    //Sep-Dic: Inicia ciclo impar, suma 1
    $semestre_calculado = $semestre_calculado + 1;
}
//Mar-Ago: Se queda igual (semestre par)

//Corrección si sale 0 o negativo (recién ingreso)
if($semestre_calculado <1) $semestre_calculado = 1;

//Variable de control
$puede_realizar_servicio = ($semestre_calculado >= 6);

//Verificar si ya hay un registro para el Servicio Social
$query_registro = "SELECT * FROM registro_servicio WHERE id_alumno = '$id_alumno'";
$res_registro = mysqli_query($conexion, $query_registro);
$tiene_registro = mysqli_num_rows($res_registro);
$datos_servicio = mysqli_fetch_assoc($res_registro);

//Si ya tiene registro, ignoramos la restricción (si es caso especial)
if($tiene_registro){
    $puede_realizar_servicio = true;
}

//Logica de fechas para reportes
$limite_informe1 = "---";
$limite_informe2 = "---";

if($tiene_registro && $datos_servicio['fecha_inicio']){
    $inicio = $datos_servicio['fecha_inicio'];
    //Calculo de tres meses 1er Informe
    $limite_informe1 = date('d/m/Y', strtotime("+3 months", strtotime($inicio)));
    //Calculo de seis meses 2do Informe
    $limite_informe2 = date('d/m/Y', strtotime("+6 months", strtotime($inicio)));
}

//Mostrar estatus de documento
function botonesAccion($archivo, $carpeta, $tipo_doc){
    if(!empty($archivo) && file_exists($carpeta . $archivo)){
        return '<div style="text-align: right;">
                    <a href="'.$carpeta.$archivo.'" target="_blank" style="color: grey; font-weight: bold; margin-right: 10px; text-decoration:none;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="eliminar_doc_servicio.php?tipo='.$tipo_doc.'" onclick="return confirm(\'¿Eliminar archivo?\')" style="color: #c62828;">
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
    <title>Servicio Social</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .info-row{ display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee; align-items: center; }
        .label-title{ font-weight: bold; color: var(--rojo-edomex); flex:1; }
        .data-value{ flex: 2; color: #333; }
        
        .form-card { background: #fdfdfd; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; margin-top: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: bold; margin-bottom: 8px; color: var(--rojo-edomex); }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; }
        
        .doc-item { background: #fff; padding: 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .doc-info { flex: 1; }
        .doc-title { font-weight: bold; font-size: 1.05rem; display: block; }
        .doc-desc { font-size: 0.9rem; color: #666; display: block; margin-top: 4px; }
        .doc-date { font-size: 0.8rem; color: #fff; background: var(--oro-edomex); padding: 2px 8px; border-radius: 10px; margin-left: 10px; display: inline-block; }
        
        .btn-subir { background: var(--rojo-edomex); color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: 0.3s; }
        .btn-subir:hover { background:#7d1d3a; }

        .card-liberado{ background: white; border-radius: 15px; padding: 50px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-top: 30px; border-top: 6px solid #2e7d32; }
        .icon-success { font-size: 5rem; color: #2e7d32; margin-bottom: 20px; }
        .text-success { color: #2e7d32; font-size: 2rem; font-weight: bold; margin: 0; }
        .text-desc { color: #555; font-size: 1.1rem; margin-top: 10px; }

        .btn-download-final { display: inline-block; background: #2e7d32; color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; margin-top: 30px; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3); transition: transform 0.2s; }
        .btn-download-final:hover { transform: translateY(-3px); background: #1b5e20; }
        
        /* ESTILOS PARA EL BLOQUEO DE SEMESTRE */
        .bloqueo-semestre {
            text-align: center;
            padding: 50px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
            border-top: 5px solid #f44336;
        }
        .icon-lock { font-size: 4rem; color: #e57373; margin-bottom: 20px; }
        .text-lock-title { font-size: 1.8rem; color: #d32f2f; margin-bottom: 10px; }
        .text-lock-desc { font-size: 1.1rem; color: #666; line-height: 1.6; }
        .badge-semestre { background: #eee; padding: 5px 10px; border-radius: 4px; font-weight: bold; color: #333; }

        /* ESTILOS DE NOTIFICACIÓN */
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
    </style>
</head>
<body>
    <?php $subtitulo = "Gestión de Servicio Social"; include 'includes/header.php'; ?>

    <div class="container">
        
        <h2 style="color: var(--rojo-edomex); border-bottom: 2px solid var(--rojo-edomex); padding-bottom: 10px; margin-top: 20px;">
            <i class="fas fa-hands-helping"></i> Servicio Social
        </h2>
        <?php if($alumno['estatus_servicio'] == 'Observaciones' && !empty($datos_servicio['observaciones'])): ?>
            <details class="notificacion-box">
                <summary class="notificacion-summary">
                    <i class="fas fa-bell" style="animation: swing 2s infinite;"></i> 
                    ¡Tienes una notificación! (Clic para ver)
                </summary>
                <div class="notificacion-content">
                    <strong>Motivo de las observaciones:</strong><br>
                    <?php echo nl2br(htmlspecialchars($datos_servicio['observaciones'])); ?>
                </div>
            </details>
        <?php endif; ?>

        <div class="info-row">
            <span class="label-title">Nombre del Alumno:</span>
            <span class="data-value"><?php echo $alumno['nombre']." ".$alumno['ap_paterno']. " ". $alumno['ap_materno']; ?></span>
        </div>
        <div class="info-row" style="border-bottom: none;">
            <span class="label-title">Semestre Actual:</span>
            <span class="data-value">
                <span class="badge-semestre">
                    <?php echo $semestre_calculado; ?>º Semestre
                </span>
            </span>
        </div>

        <?php if(!$puede_realizar_servicio): ?>
            
            <div class="bloqueo-semestre">
                <i class="fas fa-lock icon-lock"></i>
                <h2 class="text-lock-title">Trámite No Disponible</h2>
                <p class="text-lock-desc">
                    El Servicio Social esta disponible apartir de <strong>6° Semestre</strong>.
                    <br>
                    Actualmente cursas: <strong><?php echo $semestre_calculado; ?>º Semestre</strong>.
                </p>
                <div style="margin-top: 30px;">
                    <a href="menu_principal.php" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>

        <?php elseif($alumno['estatus_servicio'] == 'Liberado'): ?>

            <div class="card-liberado">
                <i class="fas fa-check-circle icon-success"></i>
                <h2 class="text-success">¡Servicio Social Liberado!</h2>
                <p class="text-desc">
                    Felicidades, has concluido satisfactoriamente tu proceso de Servicio Social.
                    <br>Tu expediente ha sido revisado y aprobado por la división académica.
                </p>

                <?php  if(!empty($datos_servicio['doc_liberacion'])): ?>
                    <a href="uploads/servicio/<?php echo $datos_servicio['doc_liberacion']; ?>" target="_blank" class="btn-download-final">
                        <i class="fas fa-file-pdf"></i> Descargar Constancia de Liberación
                    </a>
                <?php else: ?>
                    <p style="margin-top: 20px; color: #999; font-style: italic">
                        (Tu constancia digital estará disponible aquí en breve)
                    </p>
                <?php endif; ?>

                <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="menu_principal.php" style="color: #666; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>

        <?php elseif(!$tiene_registro): ?>
            
            <div class="form-card">
                <h3 style="color: #333; border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-bottom: 20px;">
                    <i class="fas fa-pencil-alt"></i> Registro de Inicio
                </h3>

                <form action="guardar_registro_servicio.php" method="POST">
                    
                    <div class="form-group">
                        <label class="form-label">Nombre de la Empresa / Institución:</label>
                        <input type="text" name="empresa" class="form-control" placeholder="Nombre completo SIN abreviaturas" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Responsable Directo:</label>
                        <input type="text" name="responsable" class="form-control" placeholder="Nombre completo" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Área de Desempeño:</label>
                        <input type="text" name="area_desempeno" class="form-control" placeholder="Ej. Recursos Humanos, Soporte Técnico" required>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Fecha de Inicio:</label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Fecha de Término:</label>
                            <input type="date" name="fecha_termino" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" style="background: var(--rojo-edomex); color: white; border: none; padding: 15px; font-weight: bold; border-radius: 5px; cursor: pointer; width: 100%; font-size: 1.1rem;">
                        GUARDAR Y REGISTRAR
                    </button>
                </form>
            </div>

        <?php else: ?>

            <div style="background: #fcfcfc; padding: 20px; border: 1px solid #ddd; border-left: 5px solid var(--oro-edomex); margin: 20px 0; border-radius: 5px;">
                <h3 style="margin: 0 0 10px 0; color: #333;"><?php echo $datos_servicio['empresa']; ?></h3>
                <p style="margin: 0; color: #666;">
                    <strong>Área de desempeño:</strong> <?php echo $datos_servicio['area_desempeno'] ?> <br>
                    <strong>Responsable:</strong> <?php echo $datos_servicio['responsable']; ?> <br>
                    <strong>Periodo:</strong> <?php echo date('d/m/Y', strtotime($datos_servicio['fecha_inicio'])); ?> al <?php echo date('d/m/Y', strtotime($datos_servicio['fecha_termino'])); ?>
                </p>
            </div>

            <h3 style="color: var(--rojo-edomex); margin-top: 30px;">Documentación Requerida</h3>
            <?php $ruta = "uploads/servicio/"; ?>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">1. Carta de Presentación</span>
                    <span class="doc-desc">Documento que expide el Departamento del Servicio Social.</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_presentacion'], $ruta, 'doc_presentacion'); ?>
                    <?php if(empty($datos_servicio['doc_presentacion'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_presentacion" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">2. Carta de Aceptación</span>
                    <span class="doc-desc">Documento que expide la empresa donde realizas el Servicio.</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_aceptacion'], $ruta, 'doc_aceptacion'); ?>
                    <?php if(empty($datos_servicio['doc_aceptacion'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_aceptacion" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">3. Informe Trimestral No. 1 <span class="doc-date">Límite: <?php echo $limite_informe1; ?></span></span>
                    <span class="doc-desc">Reporte de actividades primer trimestre.</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_informe1'], $ruta, 'doc_informe1'); ?>
                    <?php if(empty($datos_servicio['doc_informe1'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_informe1" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">4. Informe Trimestral No. 2 <span class="doc-date">Límite: <?php echo $limite_informe2; ?></span></span>
                    <span class="doc-desc">Reporte final de actividades (6 meses).</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_informe2'], $ruta, 'doc_informe2'); ?>
                    <?php if(empty($datos_servicio['doc_informe2'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_informe2" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">5. Carta de Término</span>
                    <span class="doc-desc">Documento que emite la empresa al finalizar el total de horas.</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_termino'], $ruta, 'doc_termino'); ?>
                    <?php if(empty($datos_servicio['doc_termino'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_termino" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="doc-item">
                <div class="doc-info">
                    <span class="doc-title">6. Constancia de Liberación</span>
                    <span class="doc-desc">Documento que expide el Depto. de Servicio Social.</span>
                </div>
                <div class="doc-actions">
                    <?php echo botonesAccion($datos_servicio['doc_liberacion'], $ruta, 'doc_liberacion'); ?>
                    <?php if(empty($datos_servicio['doc_liberacion'])): ?>
                        <a href="alta_doc_servicio.php?doc=doc_liberacion" class="btn-subir"><i class="fas fa-upload"></i> Subir PDF</a>
                    <?php endif; ?>
                </div>
            </div>

            <div style="background: #fff3f3; padding: 15px; border: 1px solid #ffcdd2; border-radius: 5px; margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #c62828;">¿Hubo un error en el registro?</strong>
                    <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #555;">
                        Si la fecha o la empresa son incorrectas, puedes eliminar todo el registro.
                        <br>
                        <em style="font-size: 0.8rem;">(Nota: Esto borrará todos los archivos que hayas subido)</em>
                    </p>
                </div>
                
                <a href="eliminar_registro_completo.php" 
                   onclick="return confirm('¡CUIDADO! \nEsto borrará TODOS tus datos. \n\n¿Estás seguro?');"
                   style="background: #c62828; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                   <i class="fas fa-trash-alt"></i> 
                </a>
            </div>

        <?php endif; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>