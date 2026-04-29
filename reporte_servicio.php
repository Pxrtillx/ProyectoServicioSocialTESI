<?php
session_start();
include 'includes/db.php';

// Seguridad
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit(); }


//Variables Calcular Semestre
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n"));

//Calcular ajuste de mes para la fórmula SQL
$offset_mes = 0;
if($mes_actual < 3){
    $offset_mes = -1;
} elseif ($mes_actual >= 9){
    $offset_mes = 1;
}

//Condicion SQL para filtrar alumnos aptos para servicio
$condicion_aptos = "( ((($anio_actual - CAST(LEFT(matricula, 4) AS UNSIGNED )) * 2) + $offset_mes) >= 6 OR estatus_servicio IN ('En proceso', 'Liberado'))";

//Obtener totales (Alumnos Aptos)
$res_total = mysqli_query($conexion, "SELECT COUNT(*) as total FROM alumnos WHERE $condicion_aptos");
$row_total = mysqli_fetch_assoc($res_total);
$total = $row_total['total'];

if($total == 0) $total = 1; //Evitar división por cero en los porcentajes

$res_proceso = mysqli_query($conexion, "SELECT COUNT(*) as c FROM alumnos WHERE estatus_servicio = 'En proceso'");
$c_proceso = mysqli_fetch_assoc($res_proceso)['c'];

$res_liberado = mysqli_query($conexion, "SELECT COUNT(*) as c FROM alumnos WHERE estatus_servicio = 'Liberado'");
$c_liberado = mysqli_fetch_assoc($res_liberado)['c'];

$c_inactivo = $total - ($c_proceso + $c_liberado);
if($c_inactivo < 0) $c_inactivo = 0; 

// CÁLCULO DE PORCENTAJES
$porc_proceso = round(($c_proceso / $total) * 100  , 1);
$porc_liberado = round(($c_liberado / $total) * 100, 1);
$porc_inactivo = round(($c_inactivo / $total) * 100, 1);


// CONSULTA POR GENERACIÓN (AÑO DE MATRÍCULA > 6to Semestre)
$query_anios = "
    SELECT 
        LEFT(matricula, 4) as anio,
        SUM(CASE WHEN estatus_servicio = 'En proceso' THEN 1 ELSE 0 END) as proceso,
        SUM(CASE WHEN estatus_servicio = 'Liberado' THEN 1 ELSE 0 END) as liberado,
        SUM(CASE WHEN estatus_servicio = 'Inactivo' OR estatus_servicio IS NULL OR estatus_servicio = '' THEN 1 ELSE 0 END) as inactivo,
        COUNT(*) as total_gen
    FROM alumnos 
    WHERE $condicion_aptos
    GROUP BY anio 
    ORDER BY anio DESC
";
$res_anios = mysqli_query($conexion, $query_anios);

// ---DETALLE POR AÑO SELECCIONADO ---
$alumnos_generacion = null;
$anio_seleccionado = "";

if(isset($_GET['ver_anio'])){
    $anio_seleccionado = mysqli_real_escape_string($conexion, $_GET['ver_anio']);
    // Buscar alumnos cuya matrícula comience con el año seleccionado
    $q_detalle = "SELECT * FROM alumnos WHERE matricula LIKE '$anio_seleccionado%' AND $condicion_aptos ORDER BY ap_paterno ASC";
    $alumnos_generacion = mysqli_query($conexion, $q_detalle);
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Servicio Social</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .admin-navbar {
            background-color: #333; color: white; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 1px 10px rgba(0,0,0,0.05); margin-bottom: 30px;
        }
        .admin-navbar h1 { margin: 0; font-size: 1.4rem; color: var(--oro-edomex); font-weight: bold; }
        .btn-logout { background: #7f8c8d; color: white; padding: 8px 20px; border-radius: 20px; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .btn-logout:hover { background: var(--rojo-edomex); }

        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .container-report { max-width: 1000px; margin: 30px auto; padding: 20px; }
        
        .header-report { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-back { text-decoration: none; color: #555; font-weight: bold; display: flex; align-items: center; gap: 5px; }
        
        /* Tarjetas de Porcentajes */
        .cards-percent { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card-p { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-align: center; border-top: 5px solid #ddd; }
        .card-p h2 { font-size: 2.5rem; margin: 10px 0; color: #333; }
        .card-p span { font-size: 0.9rem; color: #777; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Colores específicos */
        .border-blue { border-top-color: #2196f3; }
        .border-green { border-top-color: #2e7d32; }
        .border-gray { border-top-color: #9e9e9e; }
        
        .text-blue { color: #2196f3 !important; }
        .text-green { color: #2e7d32 !important; }
        .text-gray { color: #757575 !important; }

        /* Tabla de Generaciones */
        .table-section { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .table-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #333; color: white; padding: 12px; text-align: center; font-weight: normal; }
        td { padding: 12px; text-align: center; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        /* Badges (Etiquetas de estado) - Agregados para mantener armonía */
        .badge { padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: bold; }
        .badge-gray { background: #eee; color: #666; }
        .badge-blue { background: #e3f2fd; color: #1976d2; }
        .badge-green { background: #e8f5e9; color: #2e7d32; }

        /* Link de año */
        .link-anio { text-decoration: none; color: var(--rojo-edomex); font-weight: bold; padding: 5px 10px; border-radius: 5px; transition: 0.3s; }
        .link-anio:hover { background-color: #fce8e8; }
        .link-active { background-color: var(--rojo-edomex); color: white; }
    </style>
</head>
<body>
    <div class="header-gob"></div>
<header>
    <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3><?php echo "Gestión de Alumnos: Servicio Social"; ?>
    </h3>
</header>

    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-shield fa-lg"></i>
            <div>
                <h1>Servicio Social Alumnos: Ingeniería en Sistemas Computacionales</h1>
                <small>Análisis de Servicio Social por Generación</small>
            </div>
        </div>
            <a href="admin_servicio_social.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container-report">

        <div class="cards-percent">
            <div class="card-p border-blue">
                <i class="fas fa-briefcase" style="font-size: 1.5rem; color: #bbdefb;"></i>
                <h2 class="text-blue"><?php echo $porc_proceso; ?>%</h2>
                <span>En Proceso (<?php echo $c_proceso; ?>)</span>
            </div>

            <div class="card-p border-gray">
                <i class="fas fa-user-clock" style="font-size: 1.5rem; color: #e0e0e0;"></i>
                <h2 class="text-gray"><?php echo $porc_inactivo; ?>%</h2>
                <span>Inactivos (<?php echo $c_inactivo; ?>)</span>
            </div>

            <div class="card-p border-green">
                <i class="fas fa-check-circle" style="font-size: 1.5rem; color: #c8e6c9;"></i>
                <h2 class="text-green"><?php echo $porc_liberado; ?>%</h2>
                <span>Liberados (<?php echo $c_liberado; ?>)</span>
            </div>
        </div>

        <div class="table-section">
            <h3><i class="fas fa-calendar-alt"></i> Desglose por matrícula</h3>
            <p style="color:#666; font-size:0.9rem; margin-bottom:15px;">
                Haz clic en la matrícula para ver la lista de alumnos.
            </p>
            
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 20px;">Matrícula</th>
                        <th>Total Alumnos</th>
                        <th>Inactivos</th>
                        <th>En Proceso</th>
                        <th>Liberados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = mysqli_fetch_assoc($res_anios)): ?>
                        <?php 
                            // Resaltar fila activa si coincide con el año seleccionado
                            $bg_style = ($fila['anio'] == $anio_seleccionado) ? 'background-color: #fff9e6 !important;' : ''; 
                        ?>
                        <tr style="<?php echo $bg_style; ?>">
                            <td style="text-align: left; padding-left: 20px;">
                                <a href="reporte_servicio.php?ver_anio=<?php echo $fila['anio']; ?>" 
                                   class="link-anio <?php echo ($fila['anio'] == $anio_seleccionado) ? 'link-active' : ''; ?>">
                                    <i class="fas fa-search-plus"></i> <?php echo $fila['anio']; ?>
                                </a>
                            </td>
                            <td>
                                <b><?php echo $fila['total_gen']; ?></b>
                            </td>
                            <td>
                                <span style="color: #777;"><?php echo $fila['inactivo']; ?></span>
                            </td>
                            <td>
                                <span style="color: #1976d2; font-weight:bold;"><?php echo $fila['proceso']; ?></span>
                            </td>
                            <td>
                                <span style="color: #2e7d32; font-weight:bold;"><?php echo $fila['liberado']; ?></span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($res_anios) == 0): ?>
                        <tr>
                            <td colspan="5" style="padding: 20px; color: #999;">No hay datos registrados aún.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($alumnos_generacion): ?>
            <div class="table-section" id="detalle-generacion">
                <h3 style="color: var(--rojo-edomex);">
                    <i class="fas fa-users"></i> Alumnos de matrícula <?php echo $anio_seleccionado; ?>
                </h3>
                
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left; padding-left: 20px;">Matrícula</th>
                            <th style="text-align: left;">Nombre Completo</th>
                            <th>Semestre</th>
                            <th>Estatus Actual</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($alumnos_generacion)): ?>
                        <?php
                            $matricula_alu = $row['matricula'];
                            $anio_ingreso = intval(substr($matricula_alu, 0, 4));
                    
                            $dif_anios = $anio_actual - $anio_ingreso;
                            $semestre_calc = $dif_anios * 2;

                            if($mes_actual <3){
                                $semestre_calc = $semestre_calc -1;
                            }elseif($mes_actual >=9){
                                $semestre_calc = $semestre_calc + 1;
                            }

                            if($semestre_calc < 1) $semestre_calc = 1;
                        ?>
                            <tr>
                                <td style="text-align: left; padding-left: 20px; font-weight: bold; color: #555;">
                                    <?php echo $row['matricula']; ?>
                                </td>
                                <td style="text-align: left;">
                                    <?php echo $row['ap_paterno'] . " " . $row['ap_materno'] . " " . $row['nombre']; ?>
                                </td>
                                <td>
                                    <?php echo $semestre_calc; ?>° Semestre
                                </td>
                                <td>
                                    <?php 
                                        $st = $row['estatus_servicio'];
                                        $class = 'badge-gray';
                                        if($st == 'En proceso') $class = 'badge-blue';
                                        if($st == 'Liberado') $class = 'badge-green';
                                    ?>
                                    <span class="badge <?php echo $class; ?>"><?php echo $st ? $st : 'Inactivo'; ?></span>
                                </td>
                                <td>
                                    <a href="ver_expediente.php?id=<?php echo $row['id_alumno']; ?>" 
                                       style="color: #333; text-decoration: none;" title="Ver Expediente">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php if(mysqli_num_rows($alumnos_generacion) == 0): ?>
                            <tr>
                                <td colspan="5" style="padding: 20px; color: #999;">No se encontraron alumnos para este año.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <script>
                window.onload = function() {
                    document.getElementById('detalle-generacion').scrollIntoView({ behavior: 'smooth' });
                };
            </script>
        <?php endif; ?>

    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>