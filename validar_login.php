<?php
session_start();
include 'includes/db.php';

$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$pass = $_POST['password'];

//Administrador?
$query_admin = "SELECT ua.id_admin, ua.password, a.nombre, a.ap_paterno
                FROM usuarios_admin ua
                JOIN administradores a ON ua.id_admin = a.id_admin
                WHERE ua.correo = '$correo'";

$res_admin = mysqli_query($conexion, $query_admin);

if($res_admin && mysqli_num_rows($res_admin) > 0){
    $admin = mysqli_fetch_assoc($res_admin);

    //Verifica password
    if(password_verify($pass, $admin['password'])){
        //Crea sesión admin
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['nombre_admin'] = $admin['nombre']." ".$admin['ap_paterno'];
        $_SESSION['rol'] = 'admin'; //Diferenciador

        //Redirección menu admin
        header("Location: admin_dashboard.php");
        exit();
    }
}

//Alumno?
$query_alum = "SELECT u.password, a.id_alumno, a.nombre, a.ap_paterno
                FROM usuarios_servicio u
                JOIN alumnos a ON u.id_alumno = a.id_alumno
                WHERE u.correo = '$correo'";

$res_alum = mysqli_query($conexion, $query_alum);

if($res_alum && mysqli_num_rows($res_alum) > 0){
    $alum = mysqli_fetch_assoc($res_alum);

    //Verifica password
    if(password_verify($pass, $alum['password'])){
        //Crea sesión alumno
        $_SESSION['id_alumno'] = $alum['id_alumno'];
        $_SESSION['nombre_alumno'] = $alum['nombre']." ".$alum['ap_paterno'];
        $_SESSION['rol'] = 'alumno';

        //Redirección menú alumno
        header("Location: menu_principal.php");
        exit();
    }
}

//Si no se halla nada:
header("Location: index.php?error=Correo o contraseña incorrectos.");
exit();
?>