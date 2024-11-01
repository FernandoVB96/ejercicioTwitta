<?php
require_once("../connection/connection.php");

if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del usuario de la sesión o del perfil visitado
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : $_SESSION["user"]["id"];

// Obtener información del usuario cuyo perfil estamos viendo
$queryUser = "SELECT username FROM users WHERE id = $user_id";
$resUser = mysqli_query($connect, $queryUser);
$userInfo = mysqli_fetch_assoc($resUser);

// Obtener los seguidores del usuario cuyo perfil estamos viendo
$queryFollowers = "
    SELECT u.id, u.username
    FROM follows f
    JOIN users u ON f.users_id = u.id
    WHERE f.userToFollowId = $user_id
";

$resFollowers = mysqli_query($connect, $queryFollowers);
$followers = mysqli_fetch_all($resFollowers, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguidores de <?= htmlspecialchars($userInfo['username']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body style="background-color: #e9f5e9;">

<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #c3e6cb;">
    <div class="container-fluid">
        <a class="navbar-brand" href="main.php">
            <img src="../img/bird_logo_transparent-removebg-preview.png" alt="Logo" style="width: 50px;" class="me-2">
        </a>
        <h2 class="text-success mx-auto mb-0">Seguidores de <?= htmlspecialchars($userInfo['username']) ?></h2>
        <a href="../session/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-1 d-none d-md-block" style="background-color: #c3e6cb; height: 100vh;">
            <div class="position-sticky">
                <form method="GET" action="main.php" class="mb-3">
                    <button type="submit" class="btn btn-success w-100">Volver al Inicio</button>
                </form>
                <form method="GET" action="profile.php" class="mb-3">
                    <input type="hidden" name="id" value="<?= $user_id ?>">
                    <button type="submit" class="btn btn-secondary w-100">Volver al perfil</button>
                </form>
            </div>
        </nav>

        <main class="col-md-11 col-lg-10 px-4 mt-4">
            <h1 class="text-success">Seguidores</h1>

            <?php if (count($followers) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($followers as $user): ?>
                        <li class="list-group-item">
                            <a href="profile.php?id=<?= $user['id'] ?>" class="link-primary"><?= htmlspecialchars($user['username']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay seguidores para este usuario.</p>
            <?php endif; ?>
        </main>
    </div>
</div>

</body>
</html>
