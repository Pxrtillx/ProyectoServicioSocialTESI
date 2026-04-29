<?php
session_start();
include 'includes/db.php';

// Seguridad
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit(); }

//CONSULTA POR GENERACIÓN (AÑO)
$query_anios = "
    SELECT 
        LEFT(a.matricula, 4) as anio,
        COUNT(DISTINCT a.id_alumno) as total_gen,
        
        -- Contamos alumnos únicos por categoría
        COUNT(DISTINCT CASE WHEN e.categoria = 'acad' THEN a.id_alumno END) as c_acad,
        COUNT(DISTINCT CASE WHEN e.categoria = 'dep' THEN a.id_alumno END) as c_dep,
        COUNT(DISTINCT CASE WHEN e.categoria = 'cult' THEN a.id_alumno END) as c_cult,

        -- Contamos cuántos ya tienen 5 o más créditos (Criterio 'Avanzado')
        COUNT(DISTINCT CASE WHEN (
            SELECT COUNT(*) FROM evidencias_creditos WHERE id_alumno = a.id_alumno
        ) >= 5 THEN a.id_alumno END) as c_avanzados

    FROM alumnos a
    LEFT JOIN evidencias_creditos e ON a.id_alumno = e.id_alumno
    GROUP BY anio 
    ORDER BY anio DESC
";
$res_anios = mysqli_query($conexion, $query_anios);

//DETALLE DE ALUMNOS (Si se seleccionó un año)
$alumnos_generacion = null;
$anio_seleccionado = "";

if(isset($_GET['ver_anio'])){
    $anio_seleccionado = mysqli_real_escape_string($conexion, $_GET['ver_anio']);
    
    // Obtenemos las categorías concatenadas
    $q_detalle = "
        SELECT a.*, 
        COUNT(e.id_evidencia) as total_creditos,
        GROUP_CONCAT(DISTINCT e.categoria SEPARATOR ',') as lista_categorias
        FROM alumnos a 
        LEFT JOIN evidencias_creditos e ON a.id_alumno = e.id_alumno
        WHERE a.matricula LIKE '$anio_seleccionado%' 
        GROUP BY a.id_alumno
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
    <title>Reporte de Créditos</title>
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
        
        /* Colores Específicos Solicitados */
        .color-acad { color: #1565c0 !important; font-weight: bold; } /* Académico (Azul) */
        .color-dep { color: #2e7d32 !important; font-weight: bold; }  /* Deportivo (Verde) */
        .color-cult { color: #ef6c00 !important; font-weight: bold; } /* Cultural (Naranja) */
        
        /* Estilo para la columna de Avanzados */
        .color-avanzado { color: #333 !important; background-color: #e8f5e9; font-weight: bold; border-left: 2px solid #2e7d32; }

        /* Badges para el detalle */
        .badge-cat { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 4px; color: white; display: inline-block; }
        
        /* Estructura Tabla */
        .table-section { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .table-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; color: #555; font-weight: bold; padding: 12px; text-align: center; font-size: 0.9rem; }
        td { padding: 12px; text-align: center; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        
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
            <i class="fas fa-chart-pie fa-lg"></i> 
            <div>
                <h1>Reporte de Créditos</h1>
                <small>Estadísticas por Categoría y Matrícula</small>
            </div>
        </div>
        <a href="admin_creditos_complementarios.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container-report">

        <div class="table-section">
            <h3><i class="fas fa-calendar-alt"></i> Participación por matrícula</h3>
            <p style="color:#666; font-size:0.9rem; margin-bottom:15px;">Alumnos participando: Categoría y nivel de avance.</p>
            
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left; padding-left: 20px;">Matrícula</th>
                            <th>Total Alumnos</th>
                            <th class="color-acad">Académico</th>
                            <th class="color-dep">Deportivo</th>
                            <th class="color-cult">Cultural</th>
                            <th style="background-color: #e8f5e9; color: #2e7d32;">Alumnos Liberados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($res_anios)): ?>
                            <?php $bg_style = ($fila['anio'] == $anio_seleccionado) ? 'background-color: #fff9e6 !important;' : ''; ?>
                            <tr style="<?php echo $bg_style; ?>">
                                <td style="text-align: left; padding-left: 20px;">
                                    <a href="reporte_creditos.php?ver_anio=<?php echo $fila['anio']; ?>" class="link-anio <?php echo ($fila['anio'] == $anio_seleccionado) ? 'link-active' : ''; ?>">
                                        <i class="fas fa-search-plus"></i> <?php echo $fila['anio']; ?>
                                    </a>
                                </td>
                                <td><b><?php echo $fila['total_gen']; ?></b></td>
                                
                                <td class="color-acad"><?php echo $fila['c_acad']; ?></td>
                                <td class="color-dep"><?php echo $fila['c_dep']; ?></td>
                                <td class="color-cult"><?php echo $fila['c_cult']; ?></td>
                                
                                <td class="color-avanzado"><?php echo $fila['c_avanzados']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($res_anios) == 0): ?>
                            <tr><td colspan="6" style="padding: 20px; color: #999;">No se encontraron alumnos para esa matrícula.</td></tr>
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
                                <th>Categorías Participadas</th>
                                <th>Total Créditos</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($alumnos_generacion)): ?>
                                <?php
                                    $matricula_alu = $row['matricula'];
                                    $anio_ingreso = intval(substr($matricula_alu, 0, 4));

                                    $dif_anios = $anio_actual - $anio_ingreso;
                                    $sem_calc = $dif_anios * 2;

                                    if($mes_actual < 3) {
                                        $sem_calc = $sem_calc - 1;
                                    }elseif($mes_actual >= 9){
                                        $sem_calc = $sem_calc +1;
                                    }

                                    if($sem_calc <1) $sem_calc = 1;
                                ?>
                                <tr>
                                    <td style="text-align: left; padding-left: 20px; font-weight: bold; color: var(--rojo-edomex);"><?php echo $row['matricula']; ?></td>
                                    <td style="text-align: left;"><?php echo $row['ap_paterno'] . " " . $row['ap_materno'] . " " . $row['nombre']; ?></td>
                                    <td><span><?php echo $sem_calc; ?></span>° Semestre</td>
                                    <td>
                                        <?php 
                                            if ($row['lista_categorias']) {
                                                $cats = explode(',', $row['lista_categorias']);
                                                // Convertimos a array único por si hay duplicados en el GROUP_CONCAT
                                                $cats = array_unique($cats);
                                                
                                                foreach($cats as $cat_code) {
                                                    $cat_code = trim($cat_code);
                                                    
                                                    // Asignación de colores
                                                    $cat_bg = '#999'; 
                                                    $cat_nombre = $cat_code;

                                                    if($cat_code == 'acad'){ $cat_bg='#1565c0'; $cat_nombre='Académico'; }
                                                    if($cat_code == 'dep'){ $cat_bg='#2e7d32'; $cat_nombre='Deportivo'; }
                                                    if($cat_code == 'cult'){ $cat_bg='#ef6c00'; $cat_nombre='Cultural'; }

                                                    echo "<span class='badge-cat' style='background-color: $cat_bg;'>$cat_nombre</span> ";
                                                }
                                            } else {
                                                echo '<span style="color:#ccc;">-</span>';
                                            }
                                        ?>
                                    </td>

                                    <td style="font-weight: bold; color: #555;">
                                        <?php 
                                            // Resaltamos si es avanzado en la tabla de detalle también
                                            if($row['total_creditos'] >= 5) {
                                                echo "<span style='color: #2e7d32; font-weight:bold;'>".$row['total_creditos']." <i class='fas fa-check-circle'></i></span>";
                                            } else {
                                                echo $row['total_creditos'];
                                            }
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <a href="ver_expediente_creditos.php?id=<?php echo $row['id_alumno']; ?>" style="color: #333; text-decoration: none;" title="Ver Evidencias">
                                            <i class="fas fa-external-link-alt""></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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