<?php
session_start();

// Conexión a la base de datos
$servername = "localhost"; // Cambia si es necesario
$username_db = "root"; // Cambia por tu usuario de base de datos
$password_db = ""; // Cambia por tu contraseña de base de datos
$dbname = "base"; // Cambia por el nombre de tu base de datos

$mysqli = new mysqli($servername, $username_db, $password_db, $dbname);

// Verifica la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $nuevo_usuario = $_POST['username'];
    $nueva_contraseña = $_POST['password'];
    $nombre = $_POST['nombre'];

    // Verifica que los campos no estén vacíos
    if (empty($nuevo_usuario) || empty($nueva_contraseña) || empty($nombre)) {
        $_SESSION['alerta'] = [
            'clase' => 'alert-danger',
            'contenido' => 'Todos los campos son obligatorios.'
        ];
        header("Location: crear-cuenta.php");
        exit();
    }

    // Asegúrate de que el username no exceda la longitud máxima de TINYTEXT
    if (strlen($nuevo_usuario) > 255) { // TINYTEXT puede almacenar hasta 255 caracteres
        $_SESSION['alerta'] = [
            'clase' => 'alert-danger',
            'contenido' => 'El usuario no puede tener más de 255 caracteres.'
        ];
        header("Location: crear-cuenta.php");
        exit();
    }

    // Inserta el nuevo usuario en la base de datos (sin hash de la contraseña)
    $stmt = $mysqli->prepare("INSERT INTO accounts (username, password, nombre) VALUES (?, ?, ?)");

    // Verifica si la preparación de la declaración fue exitosa
    if ($stmt === false) {
        $_SESSION['alerta'] = [
            'clase' => 'alert-danger',
            'contenido' => 'Error en la preparación de la declaración: ' . $mysqli->error
        ];
        header("Location: crear-cuenta.php");
        exit();
    }

    $stmt->bind_param("sss", $nuevo_usuario, $nueva_contraseña, $nombre); // 'sss' indica que todos son strings

    if ($stmt->execute()) {
        $_SESSION['alerta'] = [
            'clase' => 'alert-success',
            'contenido' => 'Cuenta creada exitosamente.'
        ];
        header("Location: login.php"); // Redirige al login después de crear la cuenta
        exit();
    } else {
        $_SESSION['alerta'] = [
            'clase' => 'alert-danger',
            'contenido' => 'Error al crear la cuenta: ' . $stmt->error
        ];
        header("Location: crear-cuenta.php");
        exit();
    }

    // Solo cierra el statement si fue creado correctamente
    if ($stmt) {
        $stmt->close();
    }
}

$mysqli->close();
?>