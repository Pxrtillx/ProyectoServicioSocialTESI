<?php
session_start();
include 'includes/db.php';

//VERIFICACIÓN DE SEGURIDAD (EXCLUSIVO ADMIN)
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){
    header("Location: index.php");
    exit();
}

$id_admin = $_SESSION['id_admin'];

//Consulta datos ADMIN
$query = "SELECT * FROM administradores WHERE id_admin = '$id_admin'";
$resultado = mysqli_query($conexion, $query);
$admin = mysqli_fetch_assoc($resultado);

//CONSULTAS RÁPIDAS PARA MOSTRAR CONTADORES EN LAS TARJETAS (Opcional, no se usan abajo pero las dejé)
$total_alumnos = mysqli_num_rows(mysqli_query($conexion, "SELECT id_alumno FROM alumnos"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .menu-card {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px;
            border-bottom: 4px solid var(--oro-edomex);
            transition: transform 0.3s;
            text-decoration: none;
            color: var(--texto-oscuro);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .menu-card:hover {
            transform: translateY(-5px);
            border-bottom-color: var(--rojo-edomex);
        }
        .menu-card i { font-size: 2rem; color: var(--rojo-edomex); margin-bottom: 15px; }

        .tarjeta-bienvenida{
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            border-left: 5px solid var(--rojo-edomex);
            margin-bottom: 30px;
            position:relative;
        }

        .avatar-circulo{
            background: #f0f0f0;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display:flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-alumno h2{
            margin: 0 0 5px 0;
            color: var(--rojo-edomex);
            font-size: 1.5rem;
        }

        .btn-cerrar{
            background-color: #7f8c8d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            display: inline-block; /* Mejor control que float:left */
            margin-top: 15px;      /* Separación del texto */
            transition: background 0.3s;
        }
        .btn-cerrar:hover{
            background-color: #c0392b;
        }
        
        /*ajuste para celulares*/
        @media (max-width: 600px){
            .tarjeta-bienvenida{ flex-direction: column; text-align: center;}
            .btn-cerrar { width: 100%; text-align: center; } /* Botón completo en móvil */
        }
    </style>
</head>
<body>
    <?php 
        $subtitulo = "Secretaría de Educación, Ciencia, Tecnología e Innovación";
        include 'includes/admin_header.php'; 
    ?>

    <div class="container">
        <div class ="tarjeta-bienvenida">
            <div class="avatar-circulo">
                <i class="fas fa-user-shield" style="font-size: 2.5rem; color: var(--oro-edomex);"></i>
            </div>
            <div class="info-alumno">
                <h2>Bienvenido, <?php echo $admin['nombre']." ". $admin['ap_paterno']; ?></h2>
                <p style="margin: 0; line-height: 1.6; color:#555">
                    <strong>Matrícula:</strong> <?php echo $admin['matricula']; ?><br>
                    <strong>División Académica: </strong>Ingeniería en Sistemas Computacionales <br>
                    <strong>Rol: </strong>Administrativo
                </p>
                
                <a href="logout.php" class="btn-cerrar">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
        
        <p>Selecciona el área que deseas consultar:</p>
        <div class="menu-grid">
            <a href="admin_servicio_social.php" class="menu-card">
                <i class="fas fa-hands-helping" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Servicio Social</h3>
                <p>Estatus y documentos del Servicio Social de los alumnos</p>
            </a>

            <a href="admin_ingles.php" class="menu-card">
                <i class="fas fa-language" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Niveles de Inglés</h3>
                <p>Consulta el nivel de inglés de los alumnos</p>
            </a>

            <a href="admin_creditos_complementarios.php" class="menu-card">
                <i class="fas fa-award" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Créditos</h3>
                <p>Créditos complementarios de los alumnos</p>
            </a>

            <a href="admin_residencias.php" class="menu-card">
                <i class="fas fa-briefcase" style="font-size: 3rem; color: var(--rojo-edomex);margin-bottom: 15px;"></i>
                <h3>Residencias</h3>
                <p>Proyecto, dictamen y liberación</p>
            </a>

        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>