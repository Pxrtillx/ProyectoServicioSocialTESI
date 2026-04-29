<?php
session_start();
include 'includes/db.php';

// SEGURIDAD ADMIN
if(!isset($_SESSION['id_admin']) || $_SESSION['rol'] !== 'admin'){ header("Location: index.php"); exit(); }

if(!isset($_GET['id'])){ header("Location: admin_ingles.php"); exit(); }
$id_alumno = mysqli_real_escape_string($conexion, $_GET['id']);


// OBTENER DATOS DEL ALUMNO Y SUS DOCUMENTOS DE INGLÉS
$query = "SELECT a.*, r.* FROM alumnos a 
          LEFT JOIN avance_ingles r ON a.id_alumno = r.id_alumno 
          WHERE a.id_alumno = '$id_alumno'";
$res = mysqli_query($conexion, $query);

if(mysqli_num_rows($res) == 0){
    header("Location: admin_ingles.php?error=El alumno no existe.");
    exit();
}
$data = mysqli_fetch_assoc($res);

// Si no tiene registro en avance_ingles, redirigir
if(empty($data['id_alumno']) || $data['id_alumno'] == null){
     header("Location: admin_ingles.php?error=El alumno aún no tiene archivos de inglés.");
     exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Inglés: <?php echo $data['matricula']; ?></title>
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
            padding: 15px; border-bottom: 1px solid #eee;
        }
        .doc-item:last-child { border-bottom: none; }
        
        .btn-view { background: #333; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; }
        .btn-view:hover { background: var(--rojo-edomex); }
        
        .no-file { color: #999; font-style: italic; font-size: 0.9rem; }
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
            <i class="fas fa-language fa-lg"></i>
            <div>
                <h1>Expediente: Inglés</h1>
                <small>Ingeniería en Sistemas Computacionales</small>
            </div>
        </div>
        <a href="admin_ingles.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Regresar</a>
    </div>

    <div class="container">
        
        <div class="exp-container">
            
            <div class="col-left">
                <div class="card">
                    <h3>Datos del Alumno</h3>
                    <p><strong>Matrícula:</strong> <?php echo $data['matricula']; ?></p>
                    <p><strong>Nombre:</strong> <?php echo $data['nombre']." ".$data['ap_paterno']." ".$data['ap_materno']; ?></p>
                    <p><strong>Nivel Actual:</strong> 
                        <span style="font-weight: bold; color: var(--rojo-edomex);">
                            <?php 
                                if(!empty($data['doc_liberacion'])) echo "Liberado";
                                elseif(!empty($data['doc_nivel5'])) echo "Nivel 5"; // Agregado por si acaso
                                elseif(!empty($data['doc_nivel4'])) echo "Nivel 4";
                                elseif(!empty($data['doc_nivel3'])) echo "Nivel 3";
                                elseif(!empty($data['doc_nivel2'])) echo "Nivel 2";
                                elseif(!empty($data['doc_nivel1'])) echo "Nivel 1";
                                elseif(!empty($data['doc_colocacion'])) echo "Examen Colocación";
                                elseif(!empty($data['doc_certificacion'])) echo "Examen de Certificación";
                                else echo "Sin avance";
                            ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="col-right">
                <div class="card">
                    <h3>Documentación Entregada</h3>
                    <p style="color: #666; font-size: 0.9rem;">Haz clic en "Ver" para abrir el PDF en una nueva pestaña.</p>

                    <?php 
                        $documentos = [
                            'doc_colocacion' => 'Examen de Colocación',
                            'doc_certificacion' => 'Examen de Certificación',
                            'doc_nivel1'     => 'Constancia Nivel 1',
                            'doc_nivel2'     => 'Constancia Nivel 2',
                            'doc_nivel3'     => 'Constancia Nivel 3',
                            'doc_nivel4'     => 'Constancia Nivel 4',
                            'doc_nivel5'     => 'Constancia Nivel 5',
                            'doc_liberacion' => 'Carta de Liberación de Inglés'
                        ];

                        foreach($documentos as $columna_bd => $titulo_doc):
                            // Verificar si existe la clave en el array data antes de usarla
                            if(!array_key_exists($columna_bd, $data)) continue;

                            $archivo = $data[$columna_bd];
                            $existe = !empty($archivo);
                    ?>
                        <div class="doc-item">
                            <div>
                                <strong><?php echo $titulo_doc; ?></strong>
                                <br>
                                <?php if($existe): ?>
                                    <small style="color: green;"><i class="fas fa-check"></i> Archivo subido</small>
                                <?php else: ?>
                                    <small style="color: var(--rojo-edomex);">Pendiente</small>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($existe): ?>
                                <a href="uploads/ingles/<?php echo $archivo; ?>" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            <?php else: ?>
                                <span class="no-file">--</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                </div>          
        </div>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
</html>