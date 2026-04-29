<?php
session_start();
include 'includes/db.php'; // Necesitamos la conexión aquí también

if(!isset($_SESSION['id_alumno'])){ header("Location: index.php"); exit(); }
$id_alumno = $_SESSION['id_alumno'];

// VALIDACIÓN: Contar antes de mostrar el formulario
$query_check = "SELECT COUNT(*) as total FROM evidencias_creditos WHERE id_alumno = '$id_alumno'";
$res_check = mysqli_query($conexion, $query_check);
$row_check = mysqli_fetch_assoc($res_check);
$ya_tiene_limite = ($row_check['total'] >= 5);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Créditos Complementarios</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .upload-card{ max-width: 500px; margin: 30px auto; background: white; padding:30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top:5px solid var(--rojo-edomex); }
        .form-control{ width: 100%; padding: 10px; border:1px solid #ccc; border-radius: 5px; margin-bottom: 15px; }
        .btn-enviar{ background: var(--rojo-edomex); color:white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold; }
        .btn-disabled{ background: #ccc; cursor: not-allowed; }
        .alert-warning{ background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; border: 1px solid #ffeeba; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <?php $subtitulo = "Carga de Créditos Complementarios"; include 'includes/header.php'; ?>

    <div class="container">
        <div class="upload-card">
            <h2 style="color: var(--rojo-edomex); text-align: center;">Registrar Crédito Complementario</h2>

            <?php if(isset($_GET['error'])): ?>
                <div style="background: #f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php if($ya_tiene_limite): ?>
                <div class="alert-warning">
                    <i class="fas fa-exclamation-triangle"></i><br>
                    Ya has alcanzado el límite máximo de 5 créditos permitidos.
                </div>
                <div style="text-align: center;">
                    <a href="creditos_complementarios.php" class="btn-enviar" style="text-decoration:none; display:block;">Regresar</a>
                </div>
            <?php else: ?>
                <form action="procesar_subida_creditos.php" method="POST" enctype="multipart/form-data">
                    <label style="font-weight: bold;">1. Tipo de Crédito</label>
                    <select name="categoria" class="form-control" required>
                        <option value="acad">Académico</option>
                        <option value="dep">Deportivo</option>
                        <option value="cult">Cultural</option>
                    </select>

                    <label style="font-weight: bold;">2. Archivo de Evidencia:</label>
                    <input type="file" name="archivo" accept=".pdf" class="form-control" required>

                    <button type="submit" class="btn-enviar">Subir y Sumar Crédito</button>
                </form>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="creditos_complementarios.php" style="color: #666;">Regresar</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
</html>