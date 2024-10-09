<?php
require_once("../connection/connection.php");


if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];
$username = $_SESSION["user"]["username"];

// Manejar el envío de un nuevo tweet (publicación)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["text"])) {
    $tweet = trim($_POST["text"]);

    if (!empty($tweet)) {
        $sql = "INSERT INTO publications VALUES(null, '$user_id', '$tweet', CURDATE());";
        $res = mysqli_query($connect, $sql);
    }
}

// Obtener los tweets de las personas que sigues
$queryFollow = "SELECT p.id, p.text, p.createDate, u.username, p.userId
FROM publications p
JOIN follows f ON f.userToFollowId = p.userId
JOIN users u ON u.id = f.userToFollowId
WHERE f.users_id = $user_id
ORDER BY p.createDate DESC";

$res2 = mysqli_query($connect, $queryFollow);
$tweetsFollow = mysqli_fetch_all($res2, MYSQLI_ASSOC); // Cambiado a mysqli_fetch_all()

// Obtener todos los tweets
$queryAll = "SELECT p.id, p.text, p.createDate, u.username, p.userId
FROM publications p
JOIN users u ON p.userId = u.id
ORDER BY p.createDate DESC";

$res3 = mysqli_query($connect, $queryAll);
$tweetsAll = mysqli_fetch_all($res3, MYSQLI_ASSOC); // Cambiado a mysqli_fetch_all()
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Twitter Clone</title>
</head>
<body>

<h1><a href="profile.php?id=<?= $user_id ?>" style="text-decoration: none; color: inherit;"><?= htmlspecialchars($username) ?></a></h1>


<!-- Formulario para nuevo tweet (publicación) -->
<form method="POST" action="">
    <textarea name="text" required placeholder="Escribe tu tweet aquí..."></textarea>
    <button type="submit">Publicar Tweet</button>
</form>

<!-- Botón para ver las personas que el usuario sigue -->
<form method="GET" action="following.php">
    <input type="hidden" name="id" value="<?= $user_id ?>">
    <button type="submit">Siguiendo</button>
</form>

<form method="GET" action="followers.php">
    <input type="hidden" name="id" value="<?= $user_id ?>">
    <button type="submit">Seguidores</button>
</form>

<h2>Tweets de personas que sigues:</h2>
<?php if (count($tweetsFollow) > 0): ?>
    <ul>
        <?php foreach ($tweetsFollow as $tweet): ?>
            <li>
                <a href="profile.php?id=<?= $tweet['userId'] ?>"><?= htmlspecialchars($tweet['username']) ?></a>: <?= htmlspecialchars($tweet['text']) ?>
                <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No sigues a nadie o no hay tweets para mostrar.</p>
<?php endif; ?>

<h2>Tweets de todos:</h2>
<ul>
    <?php foreach ($tweetsAll as $tweet): ?>
        <li>
            <a href="profile.php?id=<?= $tweet['userId'] ?>"><?= htmlspecialchars($tweet['username']) ?></a>: <?= htmlspecialchars($tweet['text']) ?>
            <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
        </li>
    <?php endforeach; ?>
</ul>

<a href="../session/logout.php">Cerrar sesión</a>

</body>
</html>

