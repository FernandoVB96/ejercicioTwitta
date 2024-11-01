<?php 

if (isset($_POST["submit"])) {
    require_once("../connection/connection.php");

    $username = isset($_POST["username"]) ? mysqli_real_escape_string($connect, $_POST["username"]) : false;
    $email = isset($_POST["email"]) ? mysqli_real_escape_string($connect, trim($_POST["email"])) : false;
    $pass = isset($_POST["password"]) ? mysqli_real_escape_string($connect, $_POST["password"]) : false;
    $description = isset($_POST["description"]) ? mysqli_real_escape_string($connect, $_POST["description"]) : false;


    $arrayErrores = array();
    if (!empty($username) && !is_numeric($username)) {
        $usernameValidado = true;
    } else {
        $usernameValidado = false;
        $arrayErrores["username"] = "El username no es valido";
    }

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailValidado = true;
    } else {
        $emailValidado = false;
        $arrayErrores["email"] = "El email no es valido";
    }

    if (!empty($pass)) {
        $passValidado = true;
    } else {
        $passValidado = false;
        $arrayErrores["password"] = "El password no es valido";
    }

    $guardarUsuario = false;
    if(count($arrayErrores) == 0) {
        $guardarUsuario = true;
        
        $passSegura = password_hash($pass, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users VALUES(null, '$username', '$email', '$passSegura', '$description', CURDATE());";
        $guardar = mysqli_query($connect, $sql);

        if ($guardar) {
            $_SESSION["completado"] = "Registro completado";
        } else {
            $_SESSION["errores"]["general"] = "Fallo en el registro";
        }
    } else {
        $_SESSION["errores"] = $arrayErrores;
    }
    header("Location: ../index.php");
    exit();
}
?>
