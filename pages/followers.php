<?php
require_once("../connection/connection.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del usuario de la sesión o del perfil visitado
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : $_SESSION["user"]["id"];

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
    <title>Seguidores de <?= htmlspecialchars($user_id) ?></title>
</head>
<body>

<h1>Seguidores</h1>

<?php if (count($followers) > 0): ?>
    <ul>
        <?php foreach ($followers as $user): ?>
            <li>
                <a href="profile.php?id=<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Este usuario no tiene seguidores.</p>
<?php endif; ?>

<a href="profile.php?id=<?= $user_id ?>">Volver al perfil</a>

<a href="../session/logout.php">Cerrar sesión</a>

</body>
</html>

