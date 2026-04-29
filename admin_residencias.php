<?php
session_start();
include 'includes/db.php';

//Verificación de Seguridad
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){
    header("Location: index.php"); exit();
}

//Variables para calcular Semetre
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n"));

//Calcular ajuste de mes
$offset_mes = 0;
if($mes_actual < 3){
    $offset_mes = -1;
}elseif ($mes_actual >= 9){
    $offset_mes = 1;
}

//Filtro: ALumnos de 9no Semestre
$condicion_aptos = "( ((($anio_actual - CAST(LEFT(matricula, 4) AS UNSIGNED)) * 2) + $offset_mes) >= 9 OR estatus_residencia IN ('En proceso', 'Liberado') )";

$where = "WHERE " . $condicion_aptos;

//Logica de busqueda
if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
    $b = mysqli_real_escape_string($conexion, $_GET['busqueda']);
    //Combinar el filtro con la busqueda 
    $where .= " AND (matricula LIKE '%$b%' OR nombre LIKE '%$b%' OR ap_paterno LIKE '%$b%')";
}

//Consultas SQL
$query_alumnos = "SELECT * FROM alumnos $where ORDER BY ap_paterno ASC";
$res_alumnos = mysqli_query($conexion, $query_alumnos);

//Estadisticas rapidas (Tarjetas)
$total_aptos = mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumnos WHERE $condicion_aptos"));
$en_residencia = mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumnos WHERE estatus_residencia = 'En proceso'"));
$liberados = mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumnos WHERE estatus_residencia = 'Liberado'"));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Residencias Profesionales</title>
    <?php include 'includes/estilos.php';?>
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

        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; padding-bottom: 50px; }
        
        /* Grid de tarjetas */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        /* Tarjetas Normales */
        .stat-card {
            background: white; padding: 20px; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px;
            border-left: 5px solid transparent; 
        }
        .stat-icon {
            width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white;
        }
        .stat-info h3 { margin: 0; font-size: 2rem; color: #333; }
        .stat-info p { margin: 0; color: #777; font-size: 0.9rem; text-transform: uppercase; }

        /* BOTÓN REPORTE*/
        .card-reporte {
            background: white; 
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left-color: var(--oro-edomex);
        }
        
        .card-reporte:hover { 
            background: #e2e6ea; 
            transform: translateY(-5px);
            border-left-color: var(--rojo-edomex); 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .card-reporte .stat-icon {
            background: #495057; 
            color: white;
        }

        /* Panel de Tabla */
        .card-panel {
            background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 25px; margin-bottom: 30px; border-top: 4px solid transparent; transition: transform 0.2s;
        }
        .card-header-title {
            font-size: 1.2rem; color: #444; font-weight: bold; margin-bottom: 20px;
            border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;
        }

        .search-box { display: flex; gap: 10px; margin-bottom: 0; }
        .search-input { flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; background: #f9f9f9; }
        .btn-search { background: #333; color: white; border: none; padding: 0 20px; border-radius: 5px; cursor: pointer; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; color: #555; font-weight: bold; padding: 15px; text-align: left; border-bottom: 2px solid #ddd; font-size: 0.9rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #eee; color: #555; vertical-align: middle; }
        tr:hover { background-color: #fcfcfc; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; letter-spacing: 0.5px; }
        .badge-gray { background: #eee; color: #777; }
        .badge-blue { background: #e3f2fd; color: #1976d2; }
        .badge-green { background: #e8f5e9; color: #2e7d32; }
        
        .btn-action { background: white; color: var(--oro-edomex); border: 1px solid var(--oro-edomex); padding: 6px 15px; text-decoration: none; border-radius: 5px; font-size: 0.85rem; font-weight: bold; transition: 0.3s; }
        .btn-action:hover { background: var(--oro-edomex); color: white; }

        .alert-error {
            background-color: #fdf2f2; border: 1px solid #f8b4b4; color: #9b1c1c;
            padding: 15px; border-radius: 8px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="header-gob"></div>
<header>
    <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3>Gestión de Alumnos: Residencias Profesionales</h3>
</header>
    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-building fa-lg"></i>
            <div>
                <h1>Residencias Profesionales: Ingeniería en Sistemas Computacionales</h1>
                <small>Análisis de Residencias por Alumno</small>
            </div>
        </div>
        <a href="admin_dashboard.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="dashboard-container">

        <?php if(isset($_GET['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--rojo-edomex);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $total_aptos; ?></h3>
                    <p>Total de Alumnos</p>
                </div>
            </div>
        
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196f3;">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $en_residencia; ?></h3>
                    <p>En Residencia Profesional</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: #2e7d32;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $liberados; ?></h3>
                    <p>Liberados</p>
                </div>
            </div>

            <a href="reporte_residencias.php" class="stat-card card-reporte">
                <div class="stat-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="stat-info">
                    <h3 style="color: #333; font-size: 1.5rem;">Ver</h3>
                    <p>Reporte Detallado</p>
                </div>
            </a> 
        </div>

        <div class="card-panel" style="border-top-color: var(--oro-edomex);">
            
            <div class="card-header-title">
                <span><i class="fas fa-list-alt"></i> Directorio de Alumnos</span>
                
                <form class="search-box" method="GET">
                    <input type="text" name="busqueda" class="search-input" placeholder="Buscar alumno..." value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                    <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                    <?php if(isset($_GET['busqueda'])): ?>
                        <a href="admin_residencias.php" style="margin-left:10px; color:#c62828; text-decoration:none; display:flex; align-items:center;"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre Completo</th>
                            <th>Semestre</th>
                            <th>Estatus Residencia</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($res_alumnos) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($res_alumnos)): ?>
                                <?php
                                    // *** Lógica Cálculo de Semestre ***
                                    $matricula_alu = $row['matricula'];
                                    $anio_ingreso = intval(substr($matricula_alu, 0, 4));

                                    $dif_anios = $anio_actual - $anio_ingreso;
                                    $sem_calc = $dif_anios * 2;

                                    if($mes_actual < 3){
                                        $sem_calc = $sem_calc - 1;
                                    }elseif ($mes_actual >= 9){
                                        $sem_calc = $sem_calc + 1;
                                    }

                                    if($sem_calc < 1) $sem_calc = 1;
                                ?>
                                <tr>
                                    <td style="font-weight: bold; color: var(--rojo-edomex);">
                                        <?php echo $row['matricula']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['nombre'] . " " . $row['ap_paterno'] . " " . $row['ap_materno']; ?>
                                    </td>
                                    <td>
                                        <span><?php echo $sem_calc; ?>° Semestre</span>
                                    </td>
                                    <td>
                                        <?php 
                                            // Evaluamos la nueva columna estatus_residencia
                                            $st = $row['estatus_residencia'];
                                            $class = 'badge-gray';
                                            
                                            if($st == 'En proceso') $class = 'badge-blue';
                                            if($st == 'Liberado') $class = 'badge-green';
                                        ?>
                                        <span class="badge <?php echo $class; ?>"><?php echo ($st && $st !== 'Inactivo') ? $st : 'Sin iniciar'; ?></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="ver_expediente_residencia.php?id=<?php echo $row['id_alumno']; ?>" class="btn-action">
                                            <i class="fas fa-folder-open"></i> Abrir
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px; display:block;"></i>
                                    No se encontraron alumnos aptos o con esa búsqueda.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div> 
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>