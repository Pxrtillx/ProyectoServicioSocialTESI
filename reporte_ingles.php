<?php
session_start();
include 'includes/db.php';

// Seguridad
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit(); }

$nombre_admin = $_SESSION['nombre_admin'];

//CONSULTA POR GENERACIÓN (AÑO)
// Lógica Estricta: Un alumno solo cuenta en su nivel MÁS ALTO registrado.
$query_anios = "
    SELECT 
        LEFT(a.matricula, 4) as anio,
        COUNT(a.id_alumno) as total_gen,
        
        SUM(CASE WHEN r.doc_liberacion != '' THEN 1 ELSE 0 END) as c_lib,
        
        SUM(CASE WHEN r.doc_nivel5 != '' 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_n5,
            
        SUM(CASE WHEN r.doc_nivel4 != '' 
            AND (r.doc_nivel5 = '' OR r.doc_nivel5 IS NULL) 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_n4,
            
        SUM(CASE WHEN r.doc_nivel3 != '' 
            AND (r.doc_nivel4 = '' OR r.doc_nivel4 IS NULL) 
            AND (r.doc_nivel5 = '' OR r.doc_nivel5 IS NULL) 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_n3,
            
        SUM(CASE WHEN r.doc_nivel2 != '' 
            AND (r.doc_nivel3 = '' OR r.doc_nivel3 IS NULL) 
            AND (r.doc_nivel4 = '' OR r.doc_nivel4 IS NULL) 
            AND (r.doc_nivel5 = '' OR r.doc_nivel5 IS NULL) 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_n2,
            
        SUM(CASE WHEN r.doc_nivel1 != '' 
            AND (r.doc_nivel2 = '' OR r.doc_nivel2 IS NULL) 
            AND (r.doc_nivel3 = '' OR r.doc_nivel3 IS NULL) 
            AND (r.doc_nivel4 = '' OR r.doc_nivel4 IS NULL) 
            AND (r.doc_nivel5 = '' OR r.doc_nivel5 IS NULL) 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_n1,
            
        SUM(CASE WHEN r.doc_colocacion != '' 
            AND (r.doc_nivel1 = '' OR r.doc_nivel1 IS NULL) 
            AND (r.doc_nivel2 = '' OR r.doc_nivel2 IS NULL) 
            AND (r.doc_nivel3 = '' OR r.doc_nivel3 IS NULL) 
            AND (r.doc_nivel4 = '' OR r.doc_nivel4 IS NULL) 
            AND (r.doc_nivel5 = '' OR r.doc_nivel5 IS NULL) 
            AND (r.doc_liberacion = '' OR r.doc_liberacion IS NULL) 
            THEN 1 ELSE 0 END) as c_col

    FROM alumnos a
    LEFT JOIN avance_ingles r ON a.id_alumno = r.id_alumno
    GROUP BY anio 
    ORDER BY anio DESC
";
$res_anios = mysqli_query($conexion, $query_anios);

// DETALLE DE ALUMNOS (Si se seleccionó un año)
$alumnos_generacion = null;
$anio_seleccionado = "";

if(isset($_GET['ver_anio'])){
    $anio_seleccionado = mysqli_real_escape_string($conexion, $_GET['ver_anio']);
    
    // Consulta para obtener el estatus calculado del alumno
    $q_detalle = "
        SELECT a.*, 
        CASE 
            WHEN r.doc_liberacion != '' THEN 'Liberado'
            WHEN r.doc_nivel5 != '' THEN 'Nivel 5'
            WHEN r.doc_nivel4 != '' THEN 'Nivel 4'
            WHEN r.doc_nivel3 != '' THEN 'Nivel 3'
            WHEN r.doc_nivel2 != '' THEN 'Nivel 2'
            WHEN r.doc_nivel1 != '' THEN 'Nivel 1'
            WHEN r.doc_colocacion != '' THEN 'Examen Colocación'
            ELSE 'Sin registro'
        END as estatus_actual
        FROM alumnos a 
        LEFT JOIN avance_ingles r ON a.id_alumno = r.id_alumno
        WHERE a.matricula LIKE '$anio_seleccionado%' 
        ORDER BY a.ap_paterno ASC";
        
    $alumnos_generacion = mysqli_query($conexion, $q_detalle);
}

//Variables Calculo de Semestre
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inglés</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        body { background-color: #eef2f6; font-family: 'Segoe UI', sans-serif; }

        .admin-navbar {
            background-color: #333; color: white; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 1px 10px rgba(0,0,0,0.05); margin-bottom: 30px;
        }
        .admin-navbar h1 { margin: 0; font-size: 1.4rem; color: var(--oro-edomex); font-weight: bold; }
        .btn-logout { background: #7f8c8d; color: white; padding: 8px 20px; border-radius: 20px; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .btn-logout:hover { background: var(--rojo-edomex); }

        .container-report { max-width: 1200px; margin: 30px auto; padding: 20px; }
        
        
        .text-col { color: #9c27b0 !important; }
        .text-n1 { color: #2196f3 !important; }
        .text-n2 { color: #03a9f4 !important; }
        .text-n3 { color: #00bcd4 !important; }
        .text-n4 { color: #009688 !important; }
        .text-n5 { color: #4caf50 !important; }
        .text-lib { color: #2e7d32 !important; }

        /* Estructura Tabla */
        .table-section { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .table-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; color: #555; font-weight: bold; padding: 12px; text-align: center; font-size: 0.9rem; }
        td { padding: 12px; text-align: center; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        
        /* Badges */
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
        .badge-gray { background: #eee; color: #666; }
        .badge-purple { background: #f3e5f5; color: #7b1fa2; }
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
        <h3>Gestión de Alumnos: Ingeniería en Sistemas Computacionales</h3>
    </header>

    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-language fa-lg"></i> 
            <div>
                <h1>Reporte de Inglés</h1>
                <small>Desglose de niveles por matrícula</small>
            </div>
        </div>
        <a href="admin_ingles.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container-report">

        <div class="table-section">
            <h3><i class="fas fa-calendar-alt"></i> Desglose por matrícula</h3>
            <p style="color:#666; font-size:0.9rem; margin-bottom:15px;">Haz clic en la matrícula para ver la lista de alumnos.</p>
            
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left; padding-left: 20px;">Matrícula</th>
                            <th>Total</th>
                            <th>Coloc.</th>
                            <th>Nivel 1</th>
                            <th>Nivel 2</th>
                            <th>Nivel 3</th>
                            <th>Nivel 4</th>
                            <th>Nivel 5</th>
                            <th>Liberado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($res_anios)): ?>
                            <?php $bg_style = ($fila['anio'] == $anio_seleccionado) ? 'background-color: #fff9e6 !important;' : ''; ?>
                            <tr style="<?php echo $bg_style; ?>">
                                <td style="text-align: left; padding-left: 20px;">
                                    <a href="reporte_ingles.php?ver_anio=<?php echo $fila['anio']; ?>" class="link-anio <?php echo ($fila['anio'] == $anio_seleccionado) ? 'link-active' : ''; ?>">
                                        <i class="fas fa-search-plus"></i> <?php echo $fila['anio']; ?>
                                    </a>
                                </td>
                                <td><b><?php echo $fila['total_gen']; ?></b></td>
                                <td class="text-col"><?php echo $fila['c_col']; ?></td>
                                <td class="text-n1"><?php echo $fila['c_n1']; ?></td>
                                <td class="text-n2"><?php echo $fila['c_n2']; ?></td>
                                <td class="text-n3"><?php echo $fila['c_n3']; ?></td>
                                <td class="text-n4"><?php echo $fila['c_n4']; ?></td>
                                <td class="text-n5"><?php echo $fila['c_n5']; ?></td>
                                <td class="text-lib" style="font-weight: bold;"><?php echo $fila['c_lib']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($res_anios) == 0): ?>
                            <tr><td colspan="9" style="padding: 20px; color: #999;">No hay datos registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if($alumnos_generacion): ?>
            <div class="table-section" id="detalle-generacion">
                <h3 style="color: var(--rojo-edomex);"> <i class="fas fa-users"></i> Alumnos de matrícula <?php echo $anio_seleccionado; ?> </h3>
                <div style="overflow-x:auto;">
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
                                    $anio_ingreso = intval(substr($matricula_alu, 0,4));

                                    $dif_anios = $anio_actual - $anio_ingreso;
                                    $semestre_calc = $dif_anios * 2;

                                    if($mes_actual < 3){
                                        $semestre_calc = $semestre_calc -1;
                                    }elseif ($mes_actual >= 9){
                                        $semestre_calc = $semestre_calc + 1;
                                    }

                                    if($semestre_calc <1) $semestre_calc = 1;
                                ?>

                                <tr>
                                    <td style="text-align: left; padding-left: 20px; font-weight: bold; color: var(--rojo-edomex);"><?php echo $row['matricula']; ?></td>
                                    <td style="text-align: left;"><?php echo $row['ap_paterno'] . " " . $row['ap_materno'] . " " . $row['nombre']; ?></td>
                                    <td><span><?php echo $semestre_calc; ?>° Semestre</span></td>
                                    <td>
                                        <?php 
                                            $st = $row['estatus_actual'];
                                            if($st == 'Liberado') echo '<span class="badge badge-green">Liberado</span>';
                                            elseif($st == 'Sin registro') echo '<span class="badge badge-gray">Sin registro</span>';
                                            elseif($st == 'Examen Colocación') echo '<span class="badge badge-purple">Colocación</span>';
                                            else echo '<span class="badge badge-blue">'.$st.'</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="ver_expediente_ingles.php?id=<?php echo $row['id_alumno']; ?>" style="color: #333; text-decoration: none;" title="Ver Expediente">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($alumnos_generacion) == 0): ?>
                                <tr><td colspan="4" style="padding: 20px; color: #999;">No se encontraron alumnos para esa matrícula.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                window.onload = function() { document.getElementById('detalle-generacion').scrollIntoView({ behavior: 'smooth' }); };
            </script>
        <?php endif; ?>

    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>