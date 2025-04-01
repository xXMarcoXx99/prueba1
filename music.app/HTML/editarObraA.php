<?php
include 'db.php';

if (isset($_GET['id_obra']) && isset($_GET['id_artista']) && isset($_GET['rol'])) {
    $id_obra = intval($_GET['id_obra']);
    $id_artista = intval($_GET['id_artista']);
    $rol = $_GET['rol'];

    // Obtener la relación actual
    $stmt = $conn->prepare("SELECT * FROM obra_artista WHERE id_obra = ? AND id_artista = ? AND rol = ?");
    $stmt->bind_param("iis", $id_obra, $id_artista, $rol);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

// Actualizar el rol de un artista en una obra
if (isset($_POST['actualizar'])) {
    $id_obra = intval($_POST['id_obra']);
    $id_artista = intval($_POST['id_artista']);
    $rol_anterior = $_POST['rol_anterior'];
    $nuevo_rol = $_POST['rol'];

    $stmt = $conn->prepare("UPDATE obra_artista SET rol = ? WHERE id_obra = ? AND id_artista = ? AND rol = ?");
    $stmt->bind_param("siis", $nuevo_rol, $id_obra, $id_artista, $rol_anterior);

    if ($stmt->execute()) {
        header("Location: obrasArtistas.php");
    } else {
        echo "Error al actualizar.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Relación Obra - Artista</title>
</head>
<body>
    <h2>Editar Relación Obra - Artista</h2>
    <form action="editarObraA.php" method="POST">
        <input type="hidden" name="id_obra" value="<?= $row['id_obra'] ?>">
        <input type="hidden" name="id_artista" value="<?= $row['id_artista'] ?>">
        <input type="hidden" name="rol_anterior" value="<?= $row['rol'] ?>">

        <label>Nuevo Rol:</label>
        <select name="rol" required>
            <option value="Cantante" <?= ($row['rol'] == 'Cantante') ? 'selected' : '' ?>>Cantante</option>
            <option value="Intérprete" <?= ($row['rol'] == 'Intérprete') ? 'selected' : '' ?>>Intérprete</option>
            <option value="Compositor" <?= ($row['rol'] == 'Compositor') ? 'selected' : '' ?>>Compositor</option>
        </select>

        <button type="submit" name="actualizar">Actualizar</button>
    </form>
</body>
</html>
