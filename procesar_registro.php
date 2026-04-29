<?php 
include 'includes/db.php';

// 1. Recibir datos crudos
$matricula = mysqli_real_escape_string($conexion, trim($_POST['matricula']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));

// Recibimos las contraseñas sin encriptar todavía para poder validarlas
$password_raw = $_POST['password'];
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// --- 2. VALIDACIONES DE SEGURIDAD ---

// A) Verificar que las contraseñas coincidan
if($password_raw !== $confirm_password){
    header("Location: registro.php?error=Las contraseñas no coinciden.");
    exit();
}

// B) Validar el patrón de seguridad (Mínimo 8, 1 mayúscula, 1 minúscula, 1 número)
$patron = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}/';
if(!preg_match($patron, $password_raw)){
    header("Location: registro.php?error=La contraseña no cumple con los requisitos mínimos de seguridad.");
    exit();
}

// 3. Una vez validadas, AHORA SÍ encriptamos la contraseña
$pass = password_hash($password_raw, PASSWORD_DEFAULT);

// --- FIN VALIDACIONES ---


// 4. VALIDAR QUE EL CORREO NO EXISTA (en ninguna tabla)
$check_mail_alum = mysqli_query($conexion, "SELECT * FROM usuarios_servicio WHERE correo = '$correo'");
$check_mail_admin = mysqli_query($conexion, "SELECT * FROM usuarios_admin WHERE correo = '$correo'");

if(mysqli_num_rows($check_mail_alum) > 0 || mysqli_num_rows($check_mail_admin) > 0){
    header("Location: registro.php?error=Ese correo ya está registrado.");
    exit();
}

// 5. Busca matricula de alumno
$q_alumno = "SELECT id_alumno FROM alumnos WHERE matricula = '$matricula'";
$res_alumno = mysqli_query($conexion, $q_alumno);

if(mysqli_num_rows($res_alumno) > 0){
    //Si es alumno
    $datos = mysqli_fetch_assoc($res_alumno);
    $id = $datos['id_alumno'];
    
    //Verificar si ya tiene cuenta
    $ya_tiene_cuenta = mysqli_query($conexion, "SELECT * FROM usuarios_servicio WHERE id_alumno = '$id'");
    if(mysqli_num_rows($ya_tiene_cuenta) > 0){
        header("Location: registro.php?error=Esta matrícula ya tiene una cuenta activa.");
        exit();        
    }

    //Crear usuario ALUMNO
    $sql = "INSERT INTO usuarios_servicio (id_alumno, correo, password) VALUES ('$id', '$correo', '$pass')";
    if(mysqli_query($conexion, $sql)){
        header("Location: index.php?success=Cuenta activada con éxito. ");
        exit();
    }
}

// 6. Busca matricula admin si no fue alumno
$q_admin = "SELECT id_admin FROM administradores WHERE matricula = '$matricula'";
$res_admin = mysqli_query($conexion, $q_admin);

if(mysqli_num_rows($res_admin) > 0){
    //Si es admin
    $datos = mysqli_fetch_assoc($res_admin);
    $id = $datos['id_admin'];

    //Verificar si ya tiene cuenta
    $ya_tiene_cuenta = mysqli_query($conexion, "SELECT * FROM usuarios_admin WHERE id_admin = '$id'");
    if(mysqli_num_rows($ya_tiene_cuenta) > 0){
        header("Location: registro.php?error=Esta matrícula ya tiene una cuenta activa.");
        exit();
    }

    //Crear usuario ADMIN
    $sql = "INSERT INTO usuarios_admin (id_admin, correo, password) VALUES('$id', '$correo', '$pass')";
    if(mysqli_query($conexion, $sql)){
        header("Location: index.php?success=Cuenta activada con éxito.");
        exit();
    }
}

//Si no se encuentra registro en ninguna de las dos tablas:
header("Location: registro.php?error=La matrícula ingresada no existe en el sistema.");
exit();
?>