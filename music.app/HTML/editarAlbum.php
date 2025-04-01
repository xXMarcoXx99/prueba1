<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM albumes WHERE id_album = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Obtener lista de disqueras para el select
$disqueras = $conn->query("SELECT * FROM disqueras ORDER BY nombre ASC");

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $titulo = trim($_POST['titulo']);
    $anio = intval($_POST['anio']);
    $id_disquera = !empty($_POST['id_disquera']) ? intval($_POST['id_disquera']) : null;

    if (!empty($titulo) && $anio >= 1900 && $anio <= date('Y')) {
        $stmt = $conn->prepare("UPDATE albumes SET titulo = ?, anio = ?, id_disquera = ? WHERE id_album = ?");
        $stmt->bind_param("siii", $titulo, $anio, $id_disquera, $id);

        if ($stmt->execute()) {
            header("Location: albumes.php");
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
    <title>Editar Álbum</title>
    <link rel="stylesheet" href="stylesE.css"> <!-- Enlazamos el CSS -->
</head>
<body>
<div class="container">
    <h2>Editar Álbum</h2>
    <div class="form-container">
    <form action="editarAlbum.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id_album'] ?>">
        <input type="text" name="titulo" value="<?= htmlspecialchars($row['titulo']) ?>" required>
        <input type="number" name="anio" value="<?= $row['anio'] ?>" min="1900" max="<?= date('Y') ?>" required>
        <select name="id_disquera">
            <option value="">Sin disquera</option>
            <?php while ($d = $disqueras->fetch_assoc()): ?>
                <option value="<?= $d['id_disquera'] ?>" <?= ($row['id_disquera'] == $d['id_disquera']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
    <div>
        <div>
</body>
</html>
