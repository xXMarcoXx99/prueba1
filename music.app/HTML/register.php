<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='registro.php';</script>";
        exit();
    }

    // Verificar si el correo ya está registrado
    $sql_check = "SELECT email FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('El correo electrónico ya está registrado.'); window.location.href='register.php';</script>";
        exit();
    }
    $stmt_check->close(); // Cerrar la consulta previa

    // Si el correo no existe, proceder con el registro
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error en el registro: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="register.css"> <!-- Archivo CSS separado -->
</head>
<body>
    <div class="register-container">
        <h2>Registrarse</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required>
            </div>
            <button type="submit" class="btn-register">Registrarse</button>
        </form>
        <p class="separator">O</p>
        <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        <button class="btn-home" onclick="window.location.href='index.html'">Regresar al Inicio</button>
    </div>
</body>
</html>
