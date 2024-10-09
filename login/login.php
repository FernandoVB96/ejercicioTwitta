<?php
    require_once "../connection/connection.php";

    if (isset($_POST)) {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($connect, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);

        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            header("Location: ../pages/main.php");
        } else {
            $_SESSION["error_login"] = "Login incorrecto";
            header("Location: ../index.php");
        }
    } else {
        $_SESSION["error_login"] = "Login incorrecto";
        header("Location: ../index.php");
    }
?>


