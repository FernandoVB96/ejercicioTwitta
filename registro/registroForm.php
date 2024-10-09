

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Estilo Twitter</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Enlace a tu archivo CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container d-flex justify-content-center" style="margin-top: 50px;">
        <div class="card p-4">
            <h3 class="text-center mb-4" style="color:#1DA1F2;">Regístrate</h3>
            <form action="/registro/registro.php" method="POST" class="mt-2 mx-auto">
            <fieldset class="form-row reset p-4 align-items-center border border-primary ">
                <legend class="reset text-light border border-primary px-2 py-1">Registrate</legend>

                <div class="form-group row g-3 mt-1 mx-auto">
                    <label for="username" class="col-sm-2 col-form-label text-primary">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" id="username" class="form-control text-info" name="username" required />
                    </div>
                </div>

                <div class="form-group row g-3 mt-1 mx-auto">
                    <label for="email" class="col-sm-2 col-form-label text-primary">email:</label>
                    <div class="col input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">@</div>
                          </div>
                        <input type="email" id="email" class="form-control text-info" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                    </div>
                </div>

                <div class="form-group row g-3 mt-1 mx-auto">
                    <label for="password" class="col-sm-2 col-form-label text-primary">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" id="password" class="form-control text-info" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Debe contener al menos un número y una mayúscula y una minúscula, y al menos 8 o más carácteres"/>
                    </div>
                </div>

                <div class="form-group row g-3 mt-1 mx-auto">
                    <label for="description" class="col-sm-2 col-form-label text-primary">Descripcion:</label>
                    <div class="col-sm-10">
                        <input type="text" id="description" class="form-control text-info" name="description" placeholder="Escribe algo sobre ti"/>
                    </div>
                </div>

                <div class="row g-3 mt-2 w-25 mx-auto">
                    <input id="sendBttn" class="btn btn-primary btn-lg" type="submit" value="Send" name="submit"/>
                </div>
            </fieldset>
        </form>
            
            <!-- Botón para volver al index -->
            <div class="text-center mt-3">
                <a href="../index.php" class="btn btn-outline-secondary">Volver al Inicio</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

