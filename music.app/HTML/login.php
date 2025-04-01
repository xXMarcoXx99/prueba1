<?php
session_start();
include("db.php"); // Asegúrate de que db.php está bien configurado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validar que no haya campos vacíos
    if (empty($email) || empty($password)) {
        $_SESSION["error"] = "Por favor, completa todos los campos.";
        header("Location: login.php");
        exit();
    }

    // Consulta SQL segura para buscar el usuario por email
    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si el usuario existe
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifica la contraseña con password_verify
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $email;

            // Cerrar la consulta y redirigir a dashboard
            $stmt->close();
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["error"] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION["error"] = "El usuario no existe.";
    }

    // Cerrar consulta y conexión
    $stmt->close();
    $conn->close();

    // Redirigir con el error almacenado en sesión
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="login.css"> <!-- Usa tu CSS aquí -->
    
</head>
<body>


    <div class="login-container">
        <h2>Iniciar Sesión</h2>

         <?php if (isset($_SESSION["error"])) { ?>
            <p style='color: red; text-align: center;'><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
        <?php } ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <i>👤</i>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
                <i>🔒</i>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <p class="register-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        <button class="btn-back" onclick="window.location.href='index.html'">Regresar al Inicio</button>
    </div>

</body>
</html>
