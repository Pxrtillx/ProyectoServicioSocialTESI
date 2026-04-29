<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cuenta</title>
    <?php include 'includes/estilos.php'; ?>
    <style>
        :root {
            --rojo-edomex: #9D2449;
            --oro-edomex: #B38E5D;
            --gris-suave: #f4f4f4;
        }

        body {
            background-image: url('includes/img/wallpaper_tesi1.png'); 
            background-size: cover; /* Abarca toda la pantalla */
            background-position: center center; /* Centra la imagen */
            background-repeat: no-repeat; /* No se repite */
            background-attachment: fixed; /* Se queda fijo */
            
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            height: 100vh;
        }

        .reg-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Centrado perfecto verticalmente */
            padding: 20px;
            
            /* Filtro oscuro semitransparente para resaltar el cuadro */
            background-color: rgba(0, 0, 0, 0.5); 
        }

        .reg-container {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3); /* Sombra más fuerte */
            border-top: 6px solid var(--oro-edomex);
        }

        .reg-container h2 {
            color: var(--rojo-edomex);
            margin-bottom: 10px;
            text-align: center;
            font-size: 1.8rem;
        }

        .reg-container p {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        /* Estilo de los campos de entrada */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        /* Iconos de la izquierda (ID, Correo, Candado) */
        .form-group i.icon-left {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #999;
        }

        /* Icono del ojo (Derecha) */
        .form-group i.icon-right {
            position: absolute;
            right: 15px;
            top: 15px;
            color: #999;
            cursor: pointer;
            transition: color 0.3s;
        }

        .form-group i.icon-right:hover {
            color: var(--rojo-edomex);
        }

        .form-group input {
            width: 100%;
            padding: 12px 45px 12px 45px; /* Espacio para ambos iconos */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        .form-group input:focus {
            border-color: var(--oro-edomex);
            background-color: #fff;
            box-shadow: 0 0 8px rgba(179, 142, 93, 0.2);
            outline: none;
        }

        /* Texto de ayuda para la contraseña */
        .password-hint {
            font-size: 0.8rem;
            color: #fff;
            color: #888;
            margin-top: -15px;
            margin-bottom: 20px;
            display: block;
        }

        /* Mensaje de error de coincidencia (oculto por defecto) */
        #msg-error-pass {
            color: #9b1c1c;
            font-size: 0.85rem;
            margin-top: -15px;
            margin-bottom: 15px;
            display: none;
            font-weight: bold;
        }

        /* Botón de Registro */
        .btn-reg {
            width: 100%;
            background: var(--oro-edomex);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .btn-reg:hover {
            background: #96774e;
        }

        /* Alertas estéticas */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error { background: #fdf2f2; color: #9b1c1c; border: 1px solid #f8b4b4; }
    </style>
</head>
<body>

    <div class="reg-wrapper">
        <div class="reg-container">
            <h2>Crea tu Cuenta</h2>
            <p>Ingresa tus datos para activar tu acceso al sistema.</p>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="procesar_registro.php" method="POST" id="form-registro">
                <div class="form-group">
                    <i class="fas fa-id-card icon-left"></i>
                    <input type="text" name="matricula" placeholder="Matrícula" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="email" name="correo" placeholder="Correo Electrónico" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" name="password" id="pass" placeholder="Crear Contraseña" required 
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                           title="La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula, un número y un carácter especial (ej. @, #, $, %, &, *).">
                    <i class="fas fa-eye icon-right" onclick="togglePassword('pass', this)"></i>
                </div>
                <span class="password-hint">Mínimo 8 caracteres (Mayúsculas, minúsculas, números) y un carácter especial.</span>

                <div class="form-group">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" name="confirm_password" id="confirm_pass" placeholder="Confirmar Contraseña" required>
                    <i class="fas fa-eye icon-right" onclick="togglePassword('confirm_pass', this)"></i>
                </div>
                
                <div id="msg-error-pass"><i class="fas fa-times-circle"></i> Las contraseñas no coinciden.</div>

                <button type="submit" class="btn-reg">Activar mi cuenta</button>
            </form>

            <div style="text-align: center; margin-top: 25px;">
                <span style="color: #888;">¿Ya tienes cuenta?</span> 
                <a href="index.php" style="color: var(--rojo-edomex); text-decoration: none; font-weight: bold;"> Iniciar Sesión</a>
            </div>
        </div>
    </div>

    <script>
        // Función para el Ojo (Ver Contraseña)
        function togglePassword(inputId, icon) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Función para validar que las contraseñas sean iguales antes de enviar
        document.getElementById('form-registro').addEventListener('submit', function(event) {
            var pass = document.getElementById('pass').value;
            var confirmPass = document.getElementById('confirm_pass').value;
            var msgError = document.getElementById('msg-error-pass');

            if (pass !== confirmPass) {
                // Previene que el formulario se envíe
                event.preventDefault();
                // Muestra el mensaje de error
                msgError.style.display = 'block';
                // Resalta el campo de confirmación en rojo
                document.getElementById('confirm_pass').style.borderColor = '#9b1c1c';
            } else {
                msgError.style.display = 'none';
                document.getElementById('confirm_pass').style.borderColor = '#ddd';
            }
        });
    </script>

</body>
</html>