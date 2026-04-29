<?php
session_start();
include 'includes/db.php';

// VERIFICACIÓN DE SEGURIDAD
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){
    header("Location: index.php");
    exit();
}

// LOGICA DE BÚSQUEDA 
$where = "";
if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
    $b = mysqli_real_escape_string($conexion, $_GET['busqueda']);
    // Buscamos por matrícula o nombre
    $where = "WHERE a.matricula LIKE '%$b%' OR a.nombre LIKE '%$b%' OR a.ap_paterno LIKE '%$b%'";
}

// CONSULTA PRINCIPAL
//Conteo del total de evidencias por alumno
$query_alumnos = "
    SELECT a.*,
    COUNT(e.id_evidencia) as total_creditos
    FROM alumnos a
    LEFT JOIN evidencias_creditos e ON a.id_alumno = e.id_alumno
    $where
    GROUP BY a.id_alumno
    ORDER BY a.ap_paterno ASC
";
$res_alumnos = mysqli_query($conexion, $query_alumnos);

// CONTADORES (KPIs del Dashboard)
$total_alumnos = mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumnos"));

// Total de archivos subidos en todo el sistema
$q_evidencias = "SELECT COUNT(*) as c FROM evidencias_creditos";
$total_evidencias = mysqli_fetch_assoc(mysqli_query($conexion, $q_evidencias))['c'];

//Logica ALumnos Con Creditos Completados 
$q_completados = "
    SELECT COUNT(*) as c FROM (
        SELECT id_alumno, COUNT(id_evidencia) as total
        FROM evidencias_creditos
        GROUP BY id_alumno
        HAVING total >= 5
    ) as subquery
    ";
$alumnos_completados = mysqli_fetch_assoc(mysqli_query($conexion, $q_completados))['c'];

//Variables Calculo de Semestre
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Créditos Complementarios</title>
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

        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; padding-bottom: 50px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
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

        .card-reporte {
            background: white; text-decoration: none; cursor:pointer;transition: all 0.3s ease;
            border-left: 5px solid var(--oro-edomex);
        }
        .card-reporte:hover {
            background: #e2e6ea; transform: translateY(-5px); 
            border-left-color: var(--rojo-edomex); box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
        }
        .card-reporte .stat-icon{ background: #495057; color:white; }
        .card-reporte .stat-info h3, .card-reporte .stat-info p {color: #333;}

        /* Estilos específicos para la tabla */
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

        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; letter-spacing: 0.5px; }
        .badge-gray { background: #eee; color: #999; }
        .badge-green { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .badge-blue { background: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; }

        .btn-action { background: white; color: var(--oro-edomex); border: 1px solid var(--oro-edomex); padding: 6px 15px; text-decoration: none; border-radius: 5px; font-size: 0.85rem; font-weight: bold; transition: 0.3s; }
        .btn-action:hover { background: var(--oro-edomex); color: white; }
    </style>
</head>
<body>
    <div class="header-gob"></div>
    <header>
        <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3>Gestión de Alumnos: Créditos Complementarios</h3>
    </header>
    
    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-shapes fa-lg"></i>
            <div>
                <h1>Control de Créditos Complementarios</h1>
                <small>Ingeniería en Sistemas Computacionales</small>
            </div>
        </div>
        <a href="admin_dashboard.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="dashboard-container">

        <?php if(isset($_GET['error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: var(--rojo-edomex);">
                <div class="stat-icon" style="background: var(--rojo-edomex);"> <i class="fas fa-user-graduate"></i> </div>
                <div class="stat-info"> <h3><?php echo $total_alumnos; ?></h3> <p>Total Alumnos</p> </div>
            </div>
        
            <div class="stat-card" style="border-left-color: #1976d2;">
                <div class="stat-icon" style="background: #1976d2;"> <i class="fas fa-file-upload"></i> </div>
                <div class="stat-info"> <h3><?php echo $total_evidencias; ?></h3> <p>Constancias Subidas</p> </div>
            </div>

            <div class="stat-card" style="border-left-color: #2e7d32;">
                <div class="stat-icon" style="background: #2e7d32;"> <i class="fas fa-user-check"></i> </div>
                <div class="stat-info"> <h3><?php echo $alumnos_completados; ?></h3> <p>Con Créditos Completos</p> </div>
            </div>

            <a href="reporte_creditos.php" class="stat-card card-reporte">
                <div class="stat-icon"><i class="fas fa-chart-pie"></i></div>
                <div class="stat-info"> <h3 style="color: #333; font-size: 1.5rem;">Ver</h3><p>Desglose por Categoría</p></div>
            </a>
        </div>

        <div class="card-panel" style="border-top-color: var(--oro-edomex);">
            <div class="card-header-title">
                <span><i class="fas fa-list-ol"></i> Listado de Créditos Acumulados</span>
                
                <form class="search-box" method="GET">
                    <input type="text" name="busqueda" class="search-input" placeholder="Buscar alumno..." value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
                    <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                    <?php if(isset($_GET['busqueda'])): ?>
                        <a href="admin_creditos_complementarios.php" style="margin-left:10px; color:#c62828; text-decoration:none; display:flex; align-items:center;"><i class="fas fa-times"></i></a>
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
                            <th>Estado de Créditos</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($res_alumnos) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($res_alumnos)): ?>
                                <?php
                                    $matricula_alu = $row['matricula'];
                                    $anio_ingreso = intval(substr($matricula_alu, 0, 4));
                                    
                                    $dif_anios = $anio_actual - $anio_ingreso;
                                    $sem_calc = $dif_anios * 2;

                                    if($mes_actual < 3){
                                        $sem_calc = $sem_calc -1;
                                    }elseif($mes_actual >= 9){
                                        $sem_calc = $sem_calc +1;
                                    }

                                    if($sem_calc <1) $sem_calc = 1;
                                ?>
                                <tr>
                                    <td style="font-weight: bold; color: var(--rojo-edomex);"><?php echo $row['matricula']; ?></td>
                                    <td><?php echo $row['nombre'] . " " . $row['ap_paterno'] . " " . $row['ap_materno']; ?></td>
                                    <td><span><?php echo $sem_calc; ?>° Semestre</span></td>
                                    
                                    <td>
                                        <?php
                                        //Validacion de Creditos
                                        $total = $row['total_creditos'];
                                        $creditos_completados = ($total >= 5);

                                        if($total == 0){
                                            echo '<span class = "badge badge-gray"><i class = "fas fa-clock"></i> Sin Registro</span>';
                                        }elseif($creditos_completados){
                                            echo '<span class = "badge badge-green"><i class = "fas fa-check"></i> Completados</span>';
                                        }else{
                                            echo '<span class = "badge badge-blue"><i class = "fas fa-spinner"></i> ' . $total. ' Créditos</span>';
                                        }
                                        ?>
                                    </td>

                                    <td style="text-align: right;">
                                        <a href="ver_expediente_creditos.php?id=<?php echo $row['id_alumno']; ?>" class="btn-action">
                                            <i class="fas fa-folder-open"></i> Abrir
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center; padding: 40px; color: #999;">No se encontraron alumnos con esa búsqueda.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>