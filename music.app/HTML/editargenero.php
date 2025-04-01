<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM generos WHERE id_genero = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        $stmt = $conn->prepare("UPDATE generos SET nombre = ? WHERE id_genero = ?");
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            header("Location: generos.php");
            exit();
        } else {
            echo "<p class='error'>Error al actualizar.</p>";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Género</title>
    <link rel="stylesheet" href="stylesE.css"> <!-- Enlazamos el CSS -->
</head>
<body>
    <div class="container">
        <h2>Editar Género</h2>
        <div class="form-container">
            <form action="editargenero.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id_genero'] ?>">
                <label for="nombre">Nombre del género:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" required>
                <button type="submit" name="actualizar" class="btn-update">Actualizar</button>
                <a href="generos.php" class="btn-cancel">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
