<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM artistas WHERE id_artista = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Obtener lista de disqueras para el select
$disqueras = $conn->query("SELECT * FROM disqueras ORDER BY nombre ASC");

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $tipo = $_POST['tipo'];
    $id_disquera = !empty($_POST['id_disquera']) ? intval($_POST['id_disquera']) : null;

    if (!empty($nombre)) {
        $stmt = $conn->prepare("UPDATE artistas SET nombre = ?, tipo = ?, id_disquera = ? WHERE id_artista = ?");
        $stmt->bind_param("ssii", $nombre, $tipo, $id_disquera, $id);

        if ($stmt->execute()) {
            header("Location: artistas.php");
        } else {
            echo "Error al actualizar.";
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
    <title>Editar Artista</title>
    <link rel="stylesheet" href="stylesE.css"> <!-- Enlazamos el CSS -->

</head>
<body>
<div class="container">
    <h2>Editar Artista</h2>
    <div class="form-container">
    <form action="editarArtista.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id_artista'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" required>
        <select name="tipo">
            <option value="Cantante" <?= $row['tipo'] == 'Cantante' ? 'selected' : '' ?>>Cantante</option>
            <option value="Intérprete" <?= $row['tipo'] == 'Intérprete' ? 'selected' : '' ?>>Intérprete</option>
            <option value="Compositor" <?= $row['tipo'] == 'Compositor' ? 'selected' : '' ?>>Compositor</option>
        </select>
        <select name="id_disquera">
            <option value="">Sin disquera</option>
            <?php while ($d = $disqueras->fetch_assoc()): ?>
                <option value="<?= $d['id_disquera'] ?>" <?= ($row['id_disquera'] == $d['id_disquera']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="actualizar">Actualizar</button>
        <a href="artistas.php" class="btn-cancel">Cancelar</a>
    </form>
            </div>
        </div>
</body>
</html>
