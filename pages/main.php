<?php
require_once("../connection/connection.php");

if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];
$username = $_SESSION["user"]["username"];

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
$tweetsFollow = mysqli_fetch_all($res2, MYSQLI_ASSOC);

// Obtener todos los tweets
$queryAll = "SELECT p.id, p.text, p.createDate, u.username, p.userId
FROM publications p
JOIN users u ON p.userId = u.id
ORDER BY p.createDate DESC";

$res3 = mysqli_query($connect, $queryAll);
$tweetsAll = mysqli_fetch_all($res3, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Twitter Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body style="background-color: #e9f5e9;">
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #c3e6cb;">
        <div class="container-fluid">
            <a class="navbar-brand" href="main.php">
                <img src="../img/bird_logo_transparent-removebg-preview.png" alt="Logo" style="width: 50px;" class="me-2">
            </a>
            <a href="profile.php?id=<?= $user_id ?>" class="text-decoration-none"><h2 class="text-success mx-auto mb-0"><?= $username ?></h2></a>
            
            <a href="../session/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-1 d-none d-md-block" style="background-color: #c3e6cb; height: 100vh;">
                <div class="position-sticky">
                    <form method="GET" action="following.php" class="mb-3">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button type="submit" class="btn btn-success w-100">Siguiendo</button>
                    </form>
                    <form method="GET" action="followers.php" class="mb-3">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button type="submit" class="btn btn-success w-100">Seguidores</button>
                    </form>

                    <form method="GET" action="profile.php" class="mb-3">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button type="submit" class="btn btn-secondary mt-3 w-100">Perfil</button>
                    </form>
                </div>
            </nav>

            <main class="col-md-11 col-lg-10 px-4 mt-3">
                <div class="container text-center mb-4">
                    <form method="POST" action="" class="mx-auto" style="max-width: 400px;">
                        <div class="mb-3">
                            <textarea name="text" required class="form-control" placeholder="Escribe tu tweet aquí..." rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Publicar Tweet</button>
                    </form>
                </div>

                <h2 class="text-success text-center">Tweets de personas que sigues:</h2>
                <div class="container mb-4">
                    <?php if (count($tweetsFollow) > 0): ?>
                        <ul class="list-group">
                            <?php foreach ($tweetsFollow as $tweet): ?>
                                <li class="list-group-item">
                                    <a href="profile.php?id=<?= $tweet['userId'] ?>" style="text-decoration: none;"><?= htmlspecialchars($tweet['username']) ?></a>: <?= htmlspecialchars($tweet['text']) ?>
                                    <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No sigues a nadie o no hay tweets para mostrar.</p>
                    <?php endif; ?>
                </div>

                <h2 class="text-success text-center">Tweets de todos:</h2>
                <div class="container">
                    <ul class="list-group">
                        <?php foreach ($tweetsAll as $tweet): ?>
                            <li class="list-group-item">
                                <a href="profile.php?id=<?= $tweet['userId'] ?>" style="text-decoration: none;"><?= htmlspecialchars($tweet['username']) ?></a>: <?= htmlspecialchars($tweet['text']) ?>
                                <em>(<?= htmlspecialchars($tweet['createDate']) ?>)</em>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
