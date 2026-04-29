<?php
session_start();
include 'includes/db.php';

// SEGURIDAD ADMIN
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit(); }

if(!isset($_GET['id'])){ header("Location: admin_servicio_social.php"); exit(); }
$id_alumno = mysqli_real_escape_string($conexion, $_GET['id']);

$nombre_admin = $_SESSION['nombre_admin'];

// PROCESAR CAMBIO DE ESTATUS (Si se presiona el botón Guardar)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevo_estatus = mysqli_real_escape_string($conexion, $_POST['nuevo_estatus']);
    $observaciones = isset($_POST['observaciones']) ? mysqli_real_escape_string($conexion, $_POST['observaciones']) : '';

    // Si el estatus NO es "Observaciones", limpiamos la caja de texto
    // para no dejar mensajes de error guardados cuando el alumno ya fue liberado o está en proceso normal.
    if($nuevo_estatus !== 'Observaciones'){
        $observaciones = '';
    }

    // Actualizamos el estatus en la tabla alumnos
    $sql_update = "UPDATE alumnos SET estatus_servicio = '$nuevo_estatus' WHERE id_alumno = '$id_alumno'";
    
    // Actualizamos el mensaje de observaciones en el registro de servicio
    $sql_obs = "UPDATE registro_servicio SET observaciones = '$observaciones' WHERE id_alumno = '$id_alumno'";

    if(mysqli_query($conexion, $sql_update) && mysqli_query($conexion, $sql_obs)){
        $msg = "Estatus y observaciones actualizados correctamente.";
    }
}

// OBTENER DATOS DEL ALUMNO Y SUS DOCUMENTOS
$query = "SELECT a.*, r.* FROM alumnos a 
          JOIN registro_servicio r ON a.id_alumno = r.id_alumno 
          WHERE a.id_alumno = '$id_alumno'";
$res = mysqli_query($conexion, $query);

if(mysqli_num_rows($res) == 0){
    header("Location: admin_servicio_social.php?error=El alumno aún no esta registrado en el Servicio Social.");
    exit();
}
$data = mysqli_fetch_assoc($res);

//Validación documentos
$docs_obligatorios = [
    'doc_presentacion', 'doc_aceptacion', 'doc_informe1', 'doc_informe2', 'doc_termino', 'doc_liberacion'
];

$archivos_faltantes = 0;
foreach($docs_obligatorios as $doc){
    if(empty($data[$doc])){
        $archivos_faltantes++;
    }
}

$todo_completo = ($archivos_faltantes === 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente: <?php echo htmlspecialchars($data['matricula']); ?></title>
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
            padding: 15px; border-bottom: 1px solid #eee;
        }
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
        <h3><?php echo "Expediente de Archivos: Servicio Social"; ?></h3>
</header>
    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-shield fa-lg"></i>
            <div>
                <h1>Expediente: Servicio Social</h1>
                <small>Ingeniería en Sistemas Computacionales</small>
            </div>
        </div>
        <a href="admin_servicio_social.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
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
                        <span style="font-weight: bold; color: var(--rojo-edomex);"><?php echo $data['estatus_servicio']; ?></span>
                    </p>
                </div>

                <div class="card">
                    <h3>Datos del Servicio</h3>
                    <p><strong>Empresa:</strong> <?php echo $data['empresa']; ?></p>
                    <p><strong>Área de Desempeño:</strong> <?php echo $data['area_desempeno']; ?></p>
                    <p><strong>Responsable:</strong> <?php echo $data['responsable']; ?></p>
                    <p><strong>Fecha Inicio:</strong> <?php echo date('d/m/Y', strtotime($data['fecha_inicio'])); ?></p>
                    <p><strong>Fecha Término:</strong> <?php echo date('d/m/Y', strtotime($data['fecha_termino'])); ?></p>
                </div>

            </div>

            <div class="col-right">
                <div class="card">
                    <h3>Documentación Entregada</h3>
                    <p style="color: #666; font-size: 0.9rem;">Haz clic en "Ver" para abrir el PDF en una nueva pestaña.</p>

                    <?php 
                        $documentos = [
                            'doc_presentacion' => 'Carta de Presentación',
                            'doc_aceptacion'   => 'Carta de Aceptación',
                            'doc_informe1'     => 'Informe Trimestral 1',
                            'doc_informe2'     => 'Informe Trimestral 2',
                            'doc_termino'      => 'Carta de Término',
                            'doc_liberacion'   => 'Carta de Liberación'
                        ];

                        foreach($documentos as $columna_bd => $titulo_doc):
                            $archivo = $data[$columna_bd];
                            $existe = !empty($archivo);
                    ?>
                        <div class="doc-item">
                            <div>
                                <strong><?php echo $titulo_doc; ?></strong>
                                <br>
                                <?php if($existe): ?>
                                    <small style="color: green;"><i class="fas fa-check"></i> Archivo subido</small>
                                <?php else: ?>
                                    <small style="color: red;">Pendiente</small>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($existe): ?>
                                <a href="uploads/servicio/<?php echo $archivo; ?>" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            <?php else: ?>
                                <span class="no-file">--</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="card" style="border-top: 4px solid var(--rojo-edomex);">
                    <h3>Dictamen</h3>

                    <?php if($todo_completo): ?>
                        <form method="POST">
                            <label style="font-weight: bold; color:#555;">Actualizar estatus:</label>
                            
                            <select name="nuevo_estatus" id="select_estatus" onchange="toggleObservaciones()" style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc;">
                                <option value="En proceso" <?php if($data['estatus_servicio']=='En proceso') echo 'selected'; ?>>En proceso</option>
                                <option value="Liberado" <?php if($data['estatus_servicio']=='Liberado') echo 'selected'; ?>>Liberado</option>
                                <option value="Observaciones" <?php if($data['estatus_servicio']=='Observaciones') echo 'selected'; ?>>Con Observaciones</option>
                            </select>

                            <div id="caja_observaciones" style="display: <?php echo (isset($data['estatus_servicio']) && $data['estatus_servicio'] == 'Observaciones') ? 'block' : 'none'; ?>; margin-bottom: 15px; background: #fdfdfd; padding: 10px; border: 1px dashed #ccc; border-radius: 4px;">
                                <label style="font-weight: bold; color: #c62828; font-size: 0.9rem;"><i class="fas fa-envelope"></i> Notificación para el alumno:</label>
                                <p style="margin: 5px 0; font-size: 0.8rem; color: #666;">Si el dictamen es "Con Observaciones", escribe aquí el motivo. El alumno lo verá en su panel.</p>
                                <textarea name="observaciones" rows="4" placeholder="Ej: Tu carta de aceptación no tiene sello, por favor vuelve a subirla..." style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; resize: vertical; box-sizing: border-box;"><?php echo isset($data['observaciones']) ? htmlspecialchars($data['observaciones']) : ''; ?></textarea>
                            </div>

                            <button type="submit" style="width: 100%; padding: 12px; background: var(--oro-edomex); color: white; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 1rem;">
                                <i class="fas fa-save"></i> ACTUALIZAR ESTATUS
                            </button>
                        </form>

                    <?php else: ?>
                        <div class="alerta-bloqueo">
                            <i class="fas fa-lock"></i><strong> Opción de liberación bloqueada</strong>
                            <br>
                            El alumno no cumple con todos los requisitos. Faltan <strong><?php echo $archivos_faltantes ?></strong> archivo(s).
                        </div>
                        <button disabled style="width: 100%; padding: 12px; background: #ddd; color: #888; border: none; font-weight: bold; cursor: not-allowed; margin-top: 10px; border-radius: 4px;">
                            ESPERANDO DOCUMENTOS FALTANTES
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