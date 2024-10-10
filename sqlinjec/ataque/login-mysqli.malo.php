<?php
require_once 'config.php';
session_start();

/* Si no se han mandado los campos necesarios enviamos al formulario */
if (empty($_POST['usuario']) || empty($_POST['contraseña'])) {
    $_SESSION['alerta'] = [
        'clase' => 'alert-warning',
        'contenido' => 'Introduzca nombre de usuario y contraseña',
    ];
    header('Location: login.php');
    die();
}

/* Establecemos la conexión a la base de datos */
$conexión = new \mysqli(
    $mysql['host'],
    $mysql['usuario'],
    $mysql['contraseña'],
    $mysql['basededatos']
);

/* En caso de error mostramos el mensaje */
if ($conexión->connect_error) {
    header('Content-Type: text/plain');
    die("ERROR DE CONEXIÓN: " . $conexión->connect_error);
}

if ($conexión->set_charset('utf8') === false) {
    header('Content-Type: text/plain');
    die("ERROR JUEGO DE CARACTERES: " . $conexión->error);
}

/* Precargamos las variables del formulario */
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

/* Preparamos la consulta SQL utilizando consultas preparadas */
$stmt = $conexión->prepare("SELECT nombre, password FROM accounts WHERE username = ?");
if ($stmt === false) {
    header('Content-Type: text/plain');
    die("ERROR SQL: " . $conexión->error);
}

/* Asociamos el parámetro de la consulta */
$stmt->bind_param('s', $usuario);

/* Ejecutamos la consulta */
$stmt->execute();

/* Obtenemos el resultado */
$stmt->bind_result($nombre_db, $hash_db);
$stmt->fetch();

/* Cerramos la declaración */
$stmt->close();

/* Verificación adicional para depuración */
if (empty($hash_db)) {
    $_SESSION['alerta'] = [
        'clase' => 'alert-danger',
        'contenido' => 'Usuario no encontrado o contraseña incorrecta',
    ];
    header('Location: login.php');
    die();
}

/* Comparamos la contraseña en texto plano */
if ($hash_db !== $contraseña) {
    $_SESSION['alerta'] = [
        'clase' => 'alert-danger',
        'contenido' => 'Contraseña incorrecta',
    ];
    header('Location: login.php');
    die();
}

/* Si todo es correcto, guardamos los datos en la sesión */
$_SESSION['usuario'] = [
    'nombre' => $nombre_db, // Asigna el nombre del usuario
    'username' => $usuario, // Guarda el nombre de usuario
];

/* Redirigimos al usuario a la aplicación */
header('Location: aplicacion.php');
?>
