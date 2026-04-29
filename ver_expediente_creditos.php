<?php
session_start();
include 'includes/db.php';

//Seguridad ADMIN 
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit();}

if(!isset($_GET['id'])){ header("Location: admin_creditos_complementarios.php"); exit(); }
$id_alumno = mysqli_real_escape_string($conexion, $_GET['id']);

//Obtener datos Alumno
$query_alumno = "SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'";
$res_alumno = mysqli_query($conexion, $query_alumno);

if(mysqli_num_rows($res_alumno) == 0){
    header("Location: admin_creditos_complementarios.php?error=El alumno no esta registrado.");
    exit();
}
$data = mysqli_fetch_assoc($res_alumno);

//Obtener lista de evidencias
$query_docs = "SELECT * FROM evidencias_creditos WHERE id_alumno = '$id_alumno' ORDER BY fecha_subida DESC";
$res_docs = mysqli_query($conexion, $query_docs);

//Validacion de Progreso si Creditos = 0 muestra mensaje
if(mysqli_num_rows($res_docs) == 0){
    header("Location: admin_creditos_complementarios.php?error=El alumno no tiene Créditos Complementarios.");
    exit();
}

//Calcular resumen de creditos
$conteo = ['acad' => 0, 'dep' => 0, 'cult' => 0, 'total' => 0];

//Consulta para sumar sin afectar puntero $res_docs 
$q_stats = "SELECT categoria, COUNT(*) as c FROM evidencias_creditos WHERE id_alumno = '$id_alumno' GROUP BY categoria";
$r_stats = mysqli_query($conexion, $q_stats);

while($stat = mysqli_fetch_assoc($r_stats)){
    $cat = trim($stat['categoria']);
    $conteo[$cat] = $stat['c'];

    //Suma del total de creditos acumulados
    $conteo['total'] += $stat['c'];
}

//Total de créditos
$creditos_completados = ($conteo['total'] >= 5);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Créditos Complementarios: <?php echo $data['matricula']; ?></title>
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
            padding: 15px; border-bottom: 1px solid #eee; transition: background 0.2s;
        }
        .doc-item:hover { background-color: #f9f9f9; }
        .doc-item:last-child { border-bottom: none; }
        
        .btn-view { background: #333; color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; display: flex; align-items: center; gap: 5px; }
        .btn-view:hover { background: var(--rojo-edomex); }
        
        /* Etiquetas de Categoría */
        .tag { padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase; font-weight: bold; color: white; margin-bottom: 5px; display: inline-block; }
        .tag-acad { background-color: #1565c0; } /* Azul */
        .tag-dep { background-color: #2e7d32; }  /* Verde */
        .tag-cult { background-color: #ef6c00; } /* Naranja */
        .tag-otro { background-color: #757575; }

        .stat-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee; font-size: 0.9rem; }
        .stat-val { font-weight: bold; }
    </style>
    </style>
</head>
<body>
    <div class="header-gob"></div>
    <header>
        <h1>Tecnológico de Estudios Superiores de Ixtapaluca</h1>
        <h3>Gestión de Expedientes</h3>
    </header>

    <div class="admin-navbar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-shapes fa-lg"></i>
            <div>
                <h1>Expediente: Créditos Complementarios</h1>
                <small>Ingeniería en Sistemas Computacionales</small>
            </div>
        </div>
        <a href="admin_creditos_complementarios.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container">
        
        <div class="exp-container">
            
            <div class="col-left">
                <div class="card">
                    <h3>Datos del Alumno</h3>
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px;"><strong>Matrícula:</strong></p>
                        <span style="font-size: 1.1rem; color: var(--rojo-edomex); font-weight:bold;"><?php echo $data['matricula']; ?></span>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px;"><strong>Nombre Completo:</strong></p>
                        <span><?php echo $data['nombre']." ".$data['ap_paterno']." ".$data['ap_materno']; ?></span>
                    </div>
                    
                    <h4 style="margin-top: 30px; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px;">Resumen de Créditos</h4>
                    
                    <div class="stat-row">
                        <span><i class="fas fa-running" style="color: #2e7d32;"></i> Deportivo</span>
                        <span class="stat-val"><?php echo isset($conteo['dep']) ? $conteo['dep'] : 0; ?></span>
                    </div>
                    <div class="stat-row">
                        <span><i class="fas fa-palette" style="color: #ef6c00;"></i> Cultural</span>
                        <span class="stat-val"><?php echo isset($conteo['cult']) ? $conteo['cult'] : 0; ?></span>
                    </div>
                    <div class="stat-row">
                        <span><i class="fas fa-graduation-cap" style="color: #1565c0;"></i> Académico</span>
                        <span class="stat-val"><?php echo isset($conteo['acad']) ? $conteo['acad'] : 0; ?></span>
                    </div>
                    
                    <div class="stat-row" style="border: none; margin-top: 10px; font-size: 1.1rem; color: #333;">
                        <strong>TOTAL ACUMULADO:</strong>
                        <strong style="color: var(--oro-edomex);"><?php echo $conteo['total']; ?></strong>
                    </div>

                    <div style="margin-top: 20px;">
                        <?php if($creditos_completados): ?>
                            <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 5px; text-align: center; border: 1px solid #c8e6c9;">
                                <i class="fas fa-check-circle"></i> <strong>Créditos Completos</strong>
                            </div>
                        <?php else: ?>
                             <div style="background: #fff3e0; color: #e65100; padding: 15px; border-radius: 5px; text-align: center; border: 1px solid #ffe0b2;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; margin-bottom: 5px;"></i><br>
                                <strong>CRÉDITOS PENDIENTES</strong>
                                <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: #f57c00;">
                                    El alumno tiene <?php echo $conteo['total']; ?> de 5 créditos requeridos.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-right">
                <div class="card">
                    <h3>Evidencias Entregadas</h3>
                    <p style="color: #666; font-size: 0.9rem;">Listado de archivos PDF subidos por el alumno.</p>

                    <?php while($doc = mysqli_fetch_assoc($res_docs)): ?>
                        <?php 
                            // Determinar etiqueta visual según categoría
                            $cat_code = trim($doc['categoria']);
                            $cat_class = 'tag-otro';
                            $cat_label = ucfirst($cat_code);
                            $icono = 'fa-file';

                            if($cat_code == 'acad') { $cat_class = 'tag-acad'; $cat_label = 'Académico'; $icono = 'fa-graduation-cap'; }
                            if($cat_code == 'dep')  { $cat_class = 'tag-dep';  $cat_label = 'Deportivo'; $icono = 'fa-running'; }
                            if($cat_code == 'cult') { $cat_class = 'tag-cult'; $cat_label = 'Cultural';  $icono = 'fa-palette'; }
                            
                            // Formato de fecha
                            $fecha = date("d/m/Y h:i A", strtotime($doc['fecha_subida']));
                        ?>
                        
                        <div class="doc-item">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="width: 40px; height: 40px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #555;">
                                    <i class="fas <?php echo $icono; ?>"></i>
                                </div>

                                <div>
                                    <span class="tag <?php echo $cat_class; ?>"><?php echo $cat_label; ?></span>
                                    <div style="font-weight: bold; color: #333; margin-bottom: 2px;">
                                        Evidencia #<?php echo $doc['id_evidencia']; ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #777;">
                                        <i class="far fa-calendar-alt"></i> Subido: <?php echo $fecha; ?>
                                    </div>
                                    <div style="font-size: 0.75rem; color: #999; margin-top: 2px; font-family: monospace;">
                                        <?php echo substr($doc['nombre_archivo'], 0, 30) . '...'; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <a href="uploads/creditos/<?php echo $doc['nombre_archivo']; ?>" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                </div>
            </div>          
        </div>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
</html>
