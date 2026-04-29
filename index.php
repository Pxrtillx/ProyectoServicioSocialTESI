<?php
session_start();
if (isset($_SESSION['id_alumno'])) { header("Location: menu_principal.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        body {
            background-image: url('includes/img/wallpaper_tesi0.png'); 
            background-size: cover; /* Hace que abarque toda la pantalla */
            background-position: center center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que se repita como mosaico */
            background-attachment: fixed; /* Hace que el fondo se quede fijo al scrollear */
            
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; /* Quita los márgenes por defecto */
            height: 100vh; /* Asegura que tome el 100% del alto de la ventana */
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ajustado a 100vh para que esté perfectamente centrado */
            padding: 20px;
            
            /* Filtro oscuro semitransparente para resaltar el cuadro blanco */
            background-color: rgba(0, 0, 0, 0.5); 
        }

        .login-container { 
            max-width: 400px; 
            width: 100%;
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.3); /* Sombra más pronunciada para resaltar sobre el fondo */
            border-top: 6px solid var(--rojo-edomex); 
        }

        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h2 { color: var(--rojo-edomex); margin: 0; font-size: 1.8rem; }
        .login-header p { color: #666; margin-top: 5px; }

        .form-group { 
            margin-bottom: 20px; 
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #aaa;
            font-size: 1.1rem;
        }

        input { 
            width: 100%; 
            padding: 12px 12px 12px 45px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 1rem;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--rojo-edomex);
            background-color: #fff;
            box-shadow: 0 0 8px rgba(157, 36, 73, 0.15);
            outline: none;
        }

        .btn-login { 
            width: 100%; 
            background: var(--rojo-edomex); 
            color: white; 
            padding: 14px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 1.1rem; 
            font-weight: bold;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover { background: #7d1d3a; }

        .alert-error { 
            background: #fdf2f2; 
            color: #9b1c1c; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border: 1px solid #f8b4b4; 
            font-size: 0.9rem; 
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h2>Inicio de Sesión</h2>
                <p>Acceso al Sistema Académico</p>
            </div>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['success'])): ?>
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> 
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <form action="validar_login.php" method="POST">
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-login">Ingresar</button>
            </form>

            <p style="text-align: center; margin-top: 25px; color: #666;">
                ¿Primera vez? <a href="registro.php" style="color: var(--oro-edomex); text-decoration: none; font-weight: bold;">Registra tu cuenta aquí</a>
            </p>
        </div>
    </div>
</body>
</html>