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
</head>
<body>

<h1>Perfil de <?= htmlspecialchars($userInfo['username']) ?></h1>
<p>Email: <?= htmlspecialchars($userInfo['email']) ?></p>
<p>Descripción: <?= htmlspecialchars($userInfo['description']) ?></p>

<!-- Si el usuario logueado está viendo su propio perfil, permitir editar la descripción -->
<?php if ($current_user_id == $user_id): ?>
    <h2>Editar Descripción</h2>
    <form method="POST" action="">
        <textarea name="description" required placeholder="Nueva descripción"><?= htmlspecialchars($userInfo['description']) ?></textarea>
        <button type="submit" name="update_description">Actualizar</button>
    </form>
<?php endif; ?>

<form method="GET" action="following.php">
    <input type="hidden" name="id" value="<?= $user_id ?>">
    <button type="submit">Seguidos</button>
</form>

<form method="GET" action="followers.php">
    <input type="hidden" name="id" value="<?= $user_id ?>">
    <button type="submit">Seguidores</button>
</form>

<!-- Botón para seguir o dejar de seguir -->
<?php if ($current_user_id != $user_id): // Solo mostrar el botón si no es el propio usuario ?>
    <form method="POST" action="">
        <?php if (!$isFollowing): ?>
            <button type="submit" name="follow">Seguir</button>
        <?php else: ?>
            <button type="submit" name="unfollow">Dejar de seguir</button>
        <?php endif; ?>
    </form>
<?php endif; ?>

<h2>Tweets de <?= htmlspecialchars($userInfo['username']) ?>:</h2>
<?php if (count($tweets) > 0): ?>
    <ul>
        <?php foreach ($tweets as $tweet): ?>
            <li>
                <?= htmlspecialchars($tweet['text']) ?> <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Este usuario no ha publicado ningún tweet.</p>
<?php endif; ?>

<a href="main.php">Volver al inicio</a>

<a href="../session/logout.php">Cerrar sesión</a>

</body>
</html>
