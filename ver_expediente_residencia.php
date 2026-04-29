<?php 
session_start();
include 'includes/db.php';

//Verificacion de Seguridad ADMIN
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit();}

if(!isset($_GET['id'])){ header("Location: admin_residencias.php"); exit(); }
$id_alumno = mysqli_real_escape_string($conexion, $_GET['id']);

$nombre_admin = $_SESSION['nombre_admin'];

//Procesar cambio de Estatus
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevo_estatus = mysqli_real_escape_string($conexion, $_POST['nuevo_estatus']);
    $observaciones = isset($_POST['observaciones']) ? mysqli_real_escape_string($conexion, $_POST['observaciones']) : '';

    // Si el estatus NO es "Observaciones", limpiamos la caja de texto
    if($nuevo_estatus !== 'Observaciones'){
        $observaciones = '';
    }

    // Actualizamos el estatus en la tabla alumnos
    $sql_update = "UPDATE alumnos SET estatus_residencia = '$nuevo_estatus' WHERE id_alumno = '$id_alumno'";
    
    // Actualizamos el mensaje de observaciones en el registro de residencias
    $sql_obs = "UPDATE registro_residencias SET observaciones = '$observaciones' WHERE id_alumno = '$id_alumno'";

    if(mysqli_query($conexion, $sql_update) && mysqli_query($conexion, $sql_obs)){
        $msg = "Estatus y observaciones actualizados correctamente.";
    }
}

//Obtener datos del alumno y doc cargados
$query = "SELECT a.*, r.*, d.* FROM alumnos a
            JOIN registro_residencias r ON a.id_alumno = r.id_alumno
            JOIN documentos_residencias d ON r.id_residencia = d.id_residencia
            WHERE a.id_alumno = '$id_alumno'";
$res = mysqli_query($conexion, $query);

if(mysqli_num_rows($res) == 0){
    header("Location: admin_residencias.php?error=El alumno aún no está registrado en Residencias Profesionales.");
    exit();
}
$data = mysqli_fetch_assoc($res);

//Validacion de documentos (14)
$documentos = [
    'doc_soli_carta_pre' => '1. Solicitud Carta Presentación',
    'doc_carta_presentacion' => '2. Carta de Presentación',
    'doc_aceptacion' => '3. Carta de Aceptación',
    'doc_propuesta_antepro' => '4. Propuesta de Anteproyecto',
    'doc_caratula_antepro' => '5. Carátula de Anteproyecto',
    'doc_carta_asesor_inter' => '6. Carta Asesor Interno',
    'doc_carta_asesor_exter' => '7. Carta Asesor Externo',
    'doc_carta_asesor_metodo' => '8. Carta Asesor Metodológico',
    'doc_reportes_mensuales' => '9. Reportes Mensuales',
    'doc_termino_empresa' => '10. Carta de Término',
    'doc_evaluacion' => '11. Evaluación de Residencia',
    'doc_checklist' => '12. Checklist de Revisión',
    'doc_caratula_proyecto' => '13. Carátula del Proyecto',
    'doc_termino_final' => '14. Carta de Liberación'
];

$archivos_faltantes = 0;
foreach($documentos as $columna_bd => $titulo_doc){
    if(empty($data[$columna_bd])){
        $archivos_faltantes++;
    }
}

$todo_completo = ($archivos_faltantes == 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente de Residencia: <?php echo htmlspecialchars($data['matricula']); ?></title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .admin-navbar {background-color: #333; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 10px rgba(0,0,0,0.05); margin-bottom: 30px;}
        .admin-navbar h1 { margin: 0; font-size: 1.4rem; color: var(--oro-edomex); font-weight: bold; }
        .btn-logout { background: #7f8c8d; color: white; padding: 8px 20px; border-radius: 20px; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .btn-logout:hover { background: var(--rojo-edomex); }

        body{ background: #f4f4f4; }
        .exp-container { display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px; }
        .col-left { flex: 1; min-width: 300px; }
        .col-right { flex: 2; min-width: 400px; }
        
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card h3 { border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-top: 0; color: #333; }
        
        .doc-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 15px; border-bottom: 1px solid #eee;
        }
        .doc-item:hover { background-color: #fafafa; }
        .doc-item:last-child { border-bottom: none; }
        
        .btn-view { background: #333; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; }
        .btn-view:hover { background: var(--rojo-edomex); }
        
        .no-file { color: #999; font-style: italic; font-size: 0.9rem; }
        .alerta-bloqueo {
            background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; border: 1px solid #ffeeba; margin-top: 10px; font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="header-gob"></div>
<header>
    <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3>Gestión de Expedientes: Residencias Profesionales</h3>
</header>
    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-building fa-lg"></i>
            <div>
                <h1>Expediente: Residencias Profesionales</h1>
                <small>Ingeniería en Sistemas Computacionales</small>
            </div>
        </div>
        <a href="admin_residencias.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container">
        <?php if(isset($msg)): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                <i class="fas fa-check-circle"></i> <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <div class="exp-container">
            
            <div class="col-left">
                <div class="card">
                    <h3>Datos del Alumno</h3>
                    <p><strong>Matrícula:</strong> <?php echo $data['matricula']; ?></p>
                    <p><strong>Nombre:</strong> <?php echo $data['nombre']." ".$data['ap_paterno']." ".$data['ap_materno']; ?></p>
                    <p><strong>Estatus Actual:</strong> 
                        <span style="font-weight: bold; color: var(--rojo-edomex);"><?php echo $data['estatus_residencia']; ?></span>
                    </p>
                </div>

                <div class="card">
                    <h3>Datos del Proyecto</h3>
                    <p><strong>Empresa:</strong> <?php echo $data['empresa']; ?></p>
                    <p><strong>Nombre del Proyecto:</strong> <?php echo $data['nombre_proyecto']; ?></p>
                    <p><strong>Asesor Interno:</strong> <?php echo $data['asesor_interno']; ?></p>
                    <p><strong>Asesor Externo:</strong> <?php echo $data['asesor_externo']; ?></p>
                    <p><strong>Asesor Metodológico:</strong> <?php echo $data['asesor_metodologico']; ?></p>
                    <p><strong>Fecha Inicio:</strong> <?php echo date('d/m/Y', strtotime($data['fecha_inicio'])); ?></p>
                    <p><strong>Fecha Término:</strong> <?php echo date('d/m/Y', strtotime($data['fecha_termino'])); ?></p>
                </div>
            </div>

            <div class="col-right">
                <div class="card">
                    <h3>Documentación Entregada</h3>
                    <p style="color: #666; font-size: 0.9rem;">
                        <span style="color: var(--oro-edomex); font-weight:bold;">Progreso: </span> 
                        <?php echo (14 - $archivos_faltantes); ?> de 14 archivos listos.
                    </p>

                    <div style="border: 1px solid #eee; border-radius: 5px;">
                        <?php foreach($documentos as $columna_bd => $titulo_doc): 
                                $archivo = $data[$columna_bd];
                                $existe = !empty($archivo);
                        ?>
                            <div class="doc-item">
                                <div>
                                    <strong style="font-size: 0.95rem; color:#444;"><?php echo $titulo_doc; ?></strong>
                                    <br>
                                    <?php if($existe): ?>
                                        <small style="color: #2e7d32; font-weight:bold;"><i class="fas fa-check-circle"></i> Archivo subido</small>
                                    <?php else: ?>
                                        <small style="color: #c62828;"><i class="fas fa-times-circle"></i> Pendiente</small>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if($existe): ?>
                                    <a href="uploads/residencias/<?php echo $archivo; ?>" target="_blank" class="btn-view">
                                        <i class="fas fa-eye"></i> Ver PDF
                                    </a>
                                <?php else: ?>
                                    <span class="no-file">--</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card" style="border-top: 4px solid var(--rojo-edomex);">
                    <h3>Dictamen de Residencia</h3>

                    <?php if($todo_completo): ?>
                        <form method="POST">
                            <label style="font-weight:bold; color:#555;">Actualizar Estatus Oficial:</label>
                            
                            <select name="nuevo_estatus" id="select_estatus" onchange="toggleObservaciones()" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius:4px;">
                                <option value="En proceso" <?php if($data['estatus_residencia']=='En proceso') echo 'selected'; ?>>En proceso</option>
                                <option value="Liberado" <?php if($data['estatus_residencia']=='Liberado') echo 'selected'; ?>>Liberado</option>
                                <option value="Observaciones" <?php if($data['estatus_residencia']=='Observaciones') echo 'selected'; ?>>Con Observaciones</option>
                            </select>

                            <div id="caja_observaciones" style="display: <?php echo (isset($data['estatus_residencia']) && $data['estatus_residencia'] == 'Observaciones') ? 'block' : 'none'; ?>; margin-bottom: 15px; background: #fdfdfd; padding: 10px; border: 1px dashed #ccc; border-radius: 4px;">
                                <label style="font-weight: bold; color: #c62828; font-size: 0.9rem;"><i class="fas fa-envelope"></i> Notificación para el alumno:</label>
                                <p style="margin: 5px 0; font-size: 0.8rem; color: #666;">Si el dictamen es "Con Observaciones", escribe aquí el motivo. El alumno lo verá en su panel.</p>
                                <textarea name="observaciones" rows="4" placeholder="Ej: Faltan firmas en la carta de presentación..." style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; resize: vertical; box-sizing: border-box;"><?php echo isset($data['observaciones']) ? htmlspecialchars($data['observaciones']) : ''; ?></textarea>
                            </div>

                            <button type="submit" style="width: 100%; padding: 12px; background: var(--oro-edomex); color: white; border: none; font-weight: bold; cursor: pointer; border-radius:4px; font-size:1rem;">
                                <i class="fas fa-save"></i> ACTUALIZAR ESTATUS
                            </button>
                        </form>

                    <?php else: ?>
                        <div class="alerta-bloqueo">
                            <i class="fas fa-lock" style="font-size: 1.2rem;"></i> <strong>Opción de liberación bloqueada</strong>
                            <br><br>
                            El alumno no cumple con todos los requisitos. Faltan <strong><?php echo $archivos_faltantes; ?></strong> archivo(s) por subir al sistema.
                        </div>
                        <button disabled style="width: 100%; padding: 12px; background: #e0e0e0; color: #888; border: none; font-weight: bold; cursor: not-allowed; margin-top: 10px; border-radius:4px;">
                            ESPERANDO DOCUMENTOS
                        </button>
                    <?php endif; ?>                        
                </div>

            </div>          
        </div>
    </div>
    
    <script>
        function toggleObservaciones() {
            var select = document.getElementById("select_estatus");
            var caja = document.getElementById("caja_observaciones");
            
            if (select.value === "Observaciones") {
                caja.style.display = "block";
            } else {
                caja.style.display = "none";
            }
        }
    </script>

    <?php include 'includes/footer.php' ?>
</body>
</html>