<?php
require_once("connection/connection.php");
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Este es mi portfolio personal">
    <meta name="keywords" content="html, css, sass, bootstrap, js, portfolio, proyectos">
    <meta name="language" content="EN">
    <meta name="author" content="fernando.vaquero@avedrunasevillasj.es">
    <meta name="robots" content="index,follow">
    <meta name="revised" content="Monday, October 7th, 2024, 19:00pm">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome1">

    <!-- Añado la fuente Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"
            defer></script>

    <!-- My css -->
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <!-- My scripts -->
    <script type="text/javascript" src="js/app.js" defer></script>

    <!-- Icono al lado del titulo -->
    <link rel="shortcut icon" href="media/icon/favicon.png" type="image/xpng">

    <!-- Titulo -->
    <title>Tu nombre's portfolio</title>
</head>

<body class="bg-light">
<div id="contact" class="container">
    <?php if (isset($_SESSION["errores"])) { ?>
        <div class="alert alert-danger text-center">
            <?php var_dump($_SESSION["errores"]); ?>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION["completado"])) { ?>
        <div class="alert alert-success text-center">
            <?php echo "Registro completado"; ?>
        </div>
        <?php unset($_SESSION["completado"]); ?>
    <?php } ?>
</div>

<?php
if (isset($_SESSION["errores"])) {
    $_SESSION["errores"] = null;
    session_unset();
}
?>

<!------------------------------------------ LOGIN ------------------------------------------>

<div id="login" class="container my-4">
    <?php if (isset($_SESSION["error_login"])) { ?>
        <div class="alert alert-danger text-center">
            <?php var_dump($_SESSION["error_login"]); ?>
        </div>
    <?php } ?>

    <form action="login/login.php" method="POST" class="mx-auto" style="max-width: 400px;">
        <fieldset class="p-4 bg-white border rounded shadow-sm">
            <legend class="text-primary text-center mb-4" style="font-size: 1.5rem;">Login</legend>

            <div class="form-group mb-3">
                <label for="email" class="form-label text-muted">Email:</label>
                <div class="input-group">
                    <span class="input-group-text">@</span>
                    <input type="email" id="email" class="form-control" name="email"
                           placeholder="example@domain.com"
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label text-muted">Password:</label>
                <input type="password" id="password" class="form-control" name="password" required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       placeholder="********"
                       title="Debe contener al menos un número y una mayúscula y una minúscula, y al menos 8 o más caracteres"/>
            </div>

            <div class="d-grid">
                <button id="sendBttn2" class="btn btn-primary btn-lg">Login</button>
            </div>
        </fieldset>
    </form>
</div>

<!------------------------------------------ REGISTER ------------------------------------------>

<div id="register" class="container my-4 text-center">
    <a href="registro/registroForm.php" class="btn btn-outline-primary btn-lg">Regístrate</a>
</div>

<?php
if (isset($_SESSION["error_login"])) {
    $_SESSION["error_login"] = null;
    session_unset();
}
?>
</body>
</html>
