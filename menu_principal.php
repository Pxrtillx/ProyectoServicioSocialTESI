<?php
session_start();
include 'includes/db.php';

//verificacion de seguridad
if (!isset($_SESSION['id_alumno'])){
    header("Location: index.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];

//datos del alumno
$query = "SELECT * FROM alumnos WHERE id_alumno = '$id_alumno'";
$resultado = mysqli_query($conexion, $query);
$alumno = mysqli_fetch_assoc($resultado);

// *** CÁLCULO DE SEMESTRE PARA MOSTRAR ***
$matricula = $alumno['matricula'];
$anio_ingreso = intval(substr($matricula, 0, 4)); // Primeros 4 dígitos
$anio_actual = intval(date("Y"));
$mes_actual = intval(date("n")); // 1 al 12

// Paso 1: Cálculo base por años
$diferencia_anios = $anio_actual - $anio_ingreso;
$semestre_calculado = $diferencia_anios * 2;

// Paso 2: Ajuste por mes (Cortes en Marzo y Septiembre)
if ($mes_actual < 3) {
    // Enero-Febrero: Aún no inicia el ciclo par, restamos 1
    $semestre_calculado = $semestre_calculado - 1;
} elseif ($mes_actual >= 9) {
    // Septiembre-Diciembre: Inicia ciclo impar, sumamos 1
    $semestre_calculado = $semestre_calculado + 1;
}

// Corrección por si sale negativo o 0
if ($semestre_calculado < 1) $semestre_calculado = 1;
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
        
        /* Estilo para el dato del semestre */
        .dato-semestre {
            background: #e3f2fd;
            color: #1565c0;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-left: 5px;
        }

        .btn-cerrar{
            background-color: #7f8c8d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 15px;
            transition: background 0.3s;
        }
        .btn-cerrar:hover{
            background-color: #c0392b;
        }
        
        /*ajuste para celulares*/
        @media (max-width: 600px){
            .tarjeta-bienvenida{ flex-direction: column; text-align: center;}
            .btn-cerrar { float: none; width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <?php 
        $subtitulo = "Secretaría de Educación, Ciencia, Tecnología e Innovación";
        include 'includes/header.php'; 
    ?>

    <div class="container">
        <div class ="tarjeta-bienvenida">
            <div class="avatar-circulo">
                <i class="fas fa-user-graduate" style="font-size: 2.5rem; color: var(--oro-edomex);"></i>
            </div>
            <div class="info-alumno">
                <h2>Hola, <?php echo $alumno['nombre']." ". $alumno['ap_paterno']; ?></h2>
                <p style="margin: 0; line-height: 1.6; color:#555">
                    <strong>Matrícula:</strong> <?php echo $alumno['matricula']; ?><br>
                    <strong>Carrera:</strong> Ingeniería en Sistemas Computacionales<br>
                    <strong>Semestre:</strong> <span class="dato-semestre"><?php echo $semestre_calculado; ?>º Semestre</span>
                </p>
                
                <a href="logout.php" class="btn-cerrar">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
        
        <p>Selecciona el área que deseas consultar:</p>
        <div class="menu-grid">
            <a href="servicio_social.php" class="menu-card">
                <i class="fas fa-hands-helping" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Servicio Social</h3>
                <p>Estatus y carga de constancias</p>
            </a>

            <a href="ingles.php" class="menu-card">
                <i class="fas fa-language" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Niveles de Inglés</h3>
                <p>Consulta de niveles y liberación</p>
            </a>

            <a href="creditos_complementarios.php" class="menu-card">
                <i class="fas fa-award" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom: 15px;"></i>
                <h3>Créditos</h3>
                <p>Deportivos, culturales y académicos</p>
            </a>

            <a href="residencias.php" class="menu-card">
                <i class="fas fa-briefcase" style="font-size: 3rem; color: var(--rojo-edomex);margin-bottom: 15px;"></i>
                <h3>Residencias</h3>
                <p>Proyecto, dictamen y liberación</p>
            </a>

            <a href="https://sigaa.tesi.org.mx/index.php" class="menu-card" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-solid fa-address-book" style="font-size: 3rem; color: var(--rojo-edomex); margin-bottom:15px; "></i>
                <h3>SIGAA</h3>
                <p>Calificaciones, boletas, kardex</p>
            </a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>