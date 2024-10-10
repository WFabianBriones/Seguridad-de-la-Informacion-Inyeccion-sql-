<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Crear Cuenta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="container" style="margin-block-start: 50px;">
        <h1 class="text-center titulo-blanco">Crear Cuenta</h1>
        <?php if (isset($_SESSION['alerta'])): ?>
            <div class="alert <?= $_SESSION['alerta']['clase'] ?> text-center">
                <?= $_SESSION['alerta']['contenido'] ?>
            </div>
            <?php unset($_SESSION['alerta']); ?>
        <?php endif; ?>
        <form method="post" action="crear-cuenta.php"> <!-- Aquí procesaremos la creación de la cuenta -->
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" name="username" class="form-control" placeholder="Ingrese su usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ingrese su nombre" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Crear Cuenta</button>
        </form>
        <p class="text-center" style="margin-block-start: 15px;">
            <a href="login.php" class="enlace-blanco">Ya tengo una cuenta</a>
        </p>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>