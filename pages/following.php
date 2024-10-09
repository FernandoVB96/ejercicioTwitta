<?php
require_once("../connection/connection.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del usuario cuyo perfil se está viendo
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : $_SESSION["user"]["id"];

// Obtener los usuarios que sigue el usuario cuyo perfil estamos viendo
$queryFollowing = "
    SELECT u.id, u.username
    FROM follows f
    JOIN users u ON f.userToFollowId = u.id
    WHERE f.users_id = $user_id
";

$resFollowing = mysqli_query($connect, $queryFollowing);
$followingUsers = mysqli_fetch_all($resFollowing, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Siguiendo por <?= htmlspecialchars($user_id) ?></title>
</head>
<body>

<h1>Usuarios seguidos</h1>

<?php if (count($followingUsers) > 0): ?>
    <ul>
        <?php foreach ($followingUsers as $user): ?>
            <li>
                <a href="profile.php?id=<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Este usuario no sigue a nadie.</p>
<?php endif; ?>

<a href="profile.php?id=<?= $user_id ?>">Volver al perfil</a>

<a href="../session/logout.php">Cerrar sesión</a>

</body>
</html>

