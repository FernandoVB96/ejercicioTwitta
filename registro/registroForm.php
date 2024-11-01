<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #e9f5e9;">

    <div class="text-center">
        <div class="mb-4">
            <img src="../img/bird_logo_transparent-removebg-preview.png" alt="Logo" class="img-fluid" style="width: 150px;">
        </div>

        <form action="/registro/registro.php" method="POST" class="mx-auto" style="max-width: 400px;">
            <fieldset class="p-4 bg-white border rounded shadow-sm">
                <legend class="text-success text-center mb-4" style="font-size: 1.5rem;">Regístrate</legend>

                <div class="mb-3">
                    <label for="username" class="form-label text-success">Username:</label>
                    <input type="text" id="username" class="form-control" name="username" required />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-success">Email:</label>
                    <div class="input-group">
                        <span class="input-group-text">@</span>
                        <input type="email" id="email" class="form-control" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-success">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" required
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Debe contener al menos un número y una mayúscula y una minúscula, y al menos 8 o más caracteres"/>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label text-success">Descripción:</label>
                    <input type="text" id="description" class="form-control" name="description" placeholder="Escribe algo sobre ti"/>
                </div>

                <div class="d-grid mt-2">
                    <button id="sendBttn" class="btn btn-success btn-lg" name="submit">Enviar</button>
                </div>
            </fieldset>
        </form>
        
        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-success btn-lg">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
