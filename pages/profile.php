<?php
require_once("../connection/connection.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del usuario de la sesión
$current_user_id = $_SESSION["user"]["id"];

// Verificar si se está accediendo al perfil de otro usuario
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : $current_user_id;

// Obtener información del usuario
$queryUser = "SELECT id, username, email, description FROM users WHERE id = $user_id";
$resUser = mysqli_query($connect, $queryUser);
$userInfo = mysqli_fetch_assoc($resUser);

// Verificar si el usuario existe
if (!$userInfo) {
    die("Usuario no encontrado.");
}

// Obtener la lista de tweets del usuario
$queryTweets = "SELECT p.id, p.text, p.createDate FROM publications p WHERE p.userId = $user_id ORDER BY p.createDate DESC";
$resTweets = mysqli_query($connect, $queryTweets);
$tweets = mysqli_fetch_all($resTweets, MYSQLI_ASSOC);

// Comprobar si el usuario actual ya sigue al usuario visitado
$queryFollowCheck = "SELECT * FROM follows WHERE users_id = $current_user_id AND userToFollowId = $user_id";
$resFollowCheck = mysqli_query($connect, $queryFollowCheck);
$isFollowing = mysqli_num_rows($resFollowCheck) > 0;

// Manejar la acción de seguir/dejar de seguir
if (isset($_POST['follow'])) {
    if (!$isFollowing) {
        $sqlFollow = "INSERT INTO follows (users_id, userToFollowId) VALUES ($current_user_id, $user_id)";
        mysqli_query($connect, $sqlFollow);
        header("Location: profile.php?id=$user_id"); // Redirigir a la misma página
        exit();
    }
} elseif (isset($_POST['unfollow'])) {
    if ($isFollowing) {
        $sqlUnfollow = "DELETE FROM follows WHERE users_id = $current_user_id AND userToFollowId = $user_id";
        mysqli_query($connect, $sqlUnfollow);
        header("Location: profile.php?id=$user_id"); // Redirigir a la misma página
        exit();
    }
}

// Manejar la actualización de la descripción
if (isset($_POST['update_description'])) {
    $newDescription = trim($_POST['description']);
    // Escapar la entrada para evitar inyección SQL
    $newDescription = mysqli_real_escape_string($connect, $newDescription);
    // Consulta SQL con la variable concatenada
    $sqlUpdate = "UPDATE users SET description = '$newDescription' WHERE id = $current_user_id";
    $res = mysqli_query($connect, $sqlUpdate);

    if ($res) {
        header("Location: profile.php?id=$current_user_id"); 
        exit();
    } else {
        echo "Error al actualizar la descripción: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($userInfo['username']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body style="background-color: #e9f5e9;">

<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #c3e6cb;">
    <div class="container-fluid">
        <a class="navbar-brand" href="main.php">
            <img src="../img/bird_logo_transparent-removebg-preview.png" alt="Logo" style="width: 50px;" class="me-2">
        </a>
        <h2 class="text-success mx-auto mb-0">Perfil de <?= htmlspecialchars($userInfo['username']) ?></h2>
        <a href="../session/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-1 d-none d-md-block" style="background-color: #c3e6cb; height: 100vh;">
            <div class="position-sticky">
                <form method="GET" action="following.php" class="mb-3">
                    <input type="hidden" name="id" value="<?= $user_id ?>">
                    <button type="submit" class="btn btn-success w-100">Seguidos</button>
                </form>
                <form method="GET" action="followers.php" class="mb-3">
                    <input type="hidden" name="id" value="<?= $user_id ?>">
                    <button type="submit" class="btn btn-success w-100">Seguidores</button>
                </form>
                <a href="main.php" class="btn btn-secondary mt-3 w-100">Volver al inicio</a>
            </div>
        </nav>

        <main class="col-md-11 col-lg-10 px-4 mt-3">
            <h1 class="text-success">Perfil de <?= htmlspecialchars($userInfo['username']) ?></h1>
            <p>Email: <?= htmlspecialchars($userInfo['email']) ?></p>
            <p>Descripción: <?= htmlspecialchars($userInfo['description']) ?></p>

            <!-- Si el usuario logueado está viendo su propio perfil, permitir editar la descripción -->
            <?php if ($current_user_id == $user_id): ?>
                <h2 class="text-success">Editar Descripción</h2>
                <form method="POST" action="" class="mb-4">
                    <div class="mb-3">
                        <textarea name="description" required class="form-control" placeholder="Nueva descripción"><?= htmlspecialchars($userInfo['description']) ?></textarea>
                    </div>
                    <button type="submit" name="update_description" class="btn btn-success">Actualizar</button>
                </form>
            <?php endif; ?>

            <!-- Botón para seguir o dejar de seguir -->
            <?php if ($current_user_id != $user_id): // Solo mostrar el botón si no es el propio usuario ?>
                <form method="POST" action="" class="mb-4">
                    <?php if (!$isFollowing): ?>
                        <button type="submit" name="follow" class="btn btn-success">Seguir</button>
                    <?php else: ?>
                        <button type="submit" name="unfollow" class="btn btn-danger">Dejar de seguir</button>
                    <?php endif; ?>
                </form>
            <?php endif; ?>

            <h2 class="text-success">Tweets de <?= htmlspecialchars($userInfo['username']) ?>:</h2>
            <?php if (count($tweets) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($tweets as $tweet): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($tweet['text']) ?> <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Este usuario no ha publicado ningún tweet.</p>
            <?php endif; ?>
        </main>
    </div>
</div>

</body>
</html>
