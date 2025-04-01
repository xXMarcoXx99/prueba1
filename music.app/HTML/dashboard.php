<?php
session_start();
include("db.php"); // Asegúrate de que db.php está en la misma carpeta y correctamente configurado

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Obtiene el nombre del usuario desde la base de datos
$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Si no se encuentra el usuario, redirige al login
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Nombre del usuario
$nombre_usuario = $user["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Enlaza tu CSS aquí -->
</head>
<body>

    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?> 🎵</h2>

        <ul>
            <li><a href="Reproductor.html">Reproductor</a></li>
            <li><a href="Buscar.html">Buscar</a></li>
            <li><a href="generos.php">Géneros</a></li>
            <li><a href="disqueras.php">Disqueras</a></li>
            <li><a href="artistas.php">Artistas</a></li>
            <li><a href="albumes.php">Albumes</a></li>
            <li><a href="obrasMusicales.php">Obras musicales</a></li>
            <li><a href="obrasArtistas.php">Obras de artistas</a></li>
        </ul>

        <br>

        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>

</body>
</html>
