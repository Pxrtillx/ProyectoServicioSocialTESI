<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['id_alumno'])){header("Location: index.php"); exit(); }
$id_alumno = $_SESSION['id_alumno'];

//Datos del alumno
$query= "SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'";
$res_alumno= mysqli_query($conexion, $query);
$alumno= mysqli_fetch_assoc($res_alumno);

//Obtener evidencias y conteo real
$query_evidencias = "SELECT * FROM evidencias_creditos WHERE id_alumno = '$id_alumno' ORDER BY fecha_subida DESC";
$res_evidencias = mysqli_query($conexion, $query_evidencias);

//contadores en 0
$total_acad = 0;
$total_dep = 0;
$total_cult = 0;

//Array para contar cuantas evidencias hay en cada categoría
$evidencias_list = [];
while($fila = mysqli_fetch_assoc($res_evidencias)){
    if($fila['categoria']== 'acad') $total_acad++;
    if($fila['categoria']=='dep') $total_dep++;
    if($fila['categoria']=='cult') $total_cult++;
    $evidencias_list[] = $fila; 
}

// NUEVA LÓGICA: Calcular total general y verificar límite
$total_general = $total_acad + $total_dep + $total_cult;
$limite_alcanzado = ($total_general >= 5);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Créditos Complementarios</title>
    <?php include 'includes/estilos.php' ?>
    <style>
        .info-row{ display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee; align-items: center; }
        .label-title{ font-weight: bold; color: var(--rojo-edomex); flex: 1; }
        .data-value{ flex: 2; color:#333; }
        .badge-credito{ padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9rem; display: inline-block; }
        .acad { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
        .deport { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .cult { background: #fff3e0; color: #ef6c00; border: 1px solid #ffe0b2; } 
        
        .btn-upload { display: inline-block; background-color: var(--rojo-edomex); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .btn-upload:hover { background-color: #7d1d3a; }

        /* Estilo para botón deshabilitado */
        .btn-disabled { background-color: #ccc !important; cursor: not-allowed; pointer-events: none; }
        .msg-limite { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; border: 1px solid #ffeeba; margin-top: 20px; text-align: center; font-weight: bold; }

        .tabla-evidencias { width: 100%; margin-top: 20px; border-collapse: collapse; font-size: 0.9rem; }
        .tabla-evidencias th { background: #f4f4f4; padding: 10px; text-align: left; color: #555; }
        .tabla-evidencias td { padding: 10px; border-bottom: 1px solid #eee; }
        .tag-cat { font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; color: white; }
    </style>
</head>
<body>
    <?php $subtitulo = "Informe de Créditos Complementarios"; include 'includes/header.php'; ?>

    <div class="container">
        <h2 style="color: var(--rojo-edomex); border-bottom: 2px solid var(--oro-edomex); padding-bottom: 10px; margin-top: 20px;">
            <i class="fas fa-award"></i> Mis Créditos Complementarios
        </h2>

        <div class="info-row">
            <span class="label-title">Nombre del Alumno: </span>
            <span class="data-value"><?php echo $alumno['nombre']." ". $alumno['ap_paterno']. " ". $alumno['ap_materno']; ?></span>
        </div>

        <div class="info-row">
            <span class="label-title">Créditos Académicos: </span>
            <span class="data-value"><span class="badge-credito acad"><?php echo $total_acad; ?></span></span>
        </div>
        <div class="info-row">
            <span class="label-title">Créditos Deportivos: </span>
            <span class="data-value"><span class="badge-credito deport"><?php echo $total_dep; ?></span></span>
        </div>
        <div class="info-row">
            <span class="label-title">Créditos Culturales: </span>
            <span class="data-value"><span class="badge-credito cult"><?php echo $total_cult; ?></span></span>
        </div>

        <div style="text-align: center;">
            <?php if($limite_alcanzado): ?>
                <div class="msg-limite">
                    <i class="fas fa-info-circle"></i> Creditos Complementarios Completos.
                </div>
                <a href="#" class="btn-upload btn-disabled"><i class="fas fa-ban"></i> Créditos Completos</a>
            <?php else: ?>
                <a href="alta_creditos.php" class="btn-upload"><i class="fas fa-plus-circle"></i> Subir Nuevo Crédito</a>
            <?php endif; ?>
        </div>

        <h3 style="margin-top: 40px; color: #555;">Evidencias Entregadas</h3>
        <?php if(count($evidencias_list) > 0): ?>
            <table class="tabla-evidencias">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Archivo</th>
                        <th>Fecha</th>
                        <th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php foreach($evidencias_list as $fila):
                        $cat_color = '#999';
                        $cat_nombre = '';
                        if($fila['categoria']=='acad'){ $cat_color='#1565c0'; $cat_nombre='Académico';}
                        if($fila['categoria']=='dep'){ $cat_color='#2e7d32'; $cat_nombre='Deportivo';}
                        if($fila['categoria']=='cult'){ $cat_color='#ef6c00'; $cat_nombre='Cultural';}
                    ?>
                    <tr>
                        <td><span class="tag-cat" style="background: <?php echo $cat_color; ?>"><?php echo $cat_nombre; ?></span></td>
                        <td><?php echo substr($fila['nombre_archivo'], 0, 25) . '...'; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($fila['fecha_subida'])); ?></td>
                        <td>
                            <a href="uploads/creditos/<?php echo $fila['nombre_archivo']; ?>" target="_blank" title="Ver PDF" style="color: grey; margin-right: 10px; text-decoration: none;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="eliminar_evidencia.php?id=<?php echo $fila['id_evidencia']; ?>" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar esta evidencia?');" 
                               title="Eliminar archivo" 
                               style="color: #c62828; text-decoration: none;">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #777; font-style: italic; text-align: center; margin-top: 20px;">No has subido ninguna evidencia aún.</p>
        <?php endif; ?>

    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>