<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM obras_musicales WHERE id_obra = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Obtener lista de géneros y álbumes para el select
$generos = $conn->query("SELECT * FROM generos ORDER BY nombre ASC");
$albumes = $conn->query("SELECT * FROM albumes ORDER BY titulo ASC");

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $titulo = trim($_POST['titulo']);
    $duracion = $_POST['duracion'];
    $id_genero = !empty($_POST['id_genero']) ? intval($_POST['id_genero']) : null;
    $id_album = !empty($_POST['id_album']) ? intval($_POST['id_album']) : null;

    if (!empty($titulo) && !empty($duracion)) {
        $stmt = $conn->prepare("UPDATE obras_musicales SET titulo = ?, duracion = ?, id_genero = ?, id_album = ? WHERE id_obra = ?");
        $stmt->bind_param("ssiii", $titulo, $duracion, $id_genero, $id_album, $id);

        if ($stmt->execute()) {
            header("Location: obrasMusicales.php");
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
    <title>Editar Obra Musical</title>
    <link rel="stylesheet" href="stylesE.css">
</head>
<body>
    <div class="container">
        <h2>Editar Obra Musical</h2>
        <div class="form-container">
            <form action="editarObraA.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id_obra'] ?>">

                <label for="titulo">Título:</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($row['titulo']) ?>" required>

                <label for="duracion">Duración (mm:ss):</label>
                <input type="text" name="duracion" value="<?= htmlspecialchars($row['duracion']) ?>" pattern="^[0-9]{1,2}:[0-5][0-9]$" required>

                <label for="id_genero">Género:</label>
                <select name="id_genero">
                    <option value="">Sin género</option>
                    <?php while ($g = $generos->fetch_assoc()): ?>
                        <option value="<?= $g['id_genero'] ?>" <?= ($row['id_genero'] == $g['id_genero']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['nombre']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="id_album">Álbum:</label>
                <select name="id_album">
                    <option value="">Sin álbum</option>
                    <?php while ($a = $albumes->fetch_assoc()): ?>
                        <option value="<?= $a['id_album'] ?>" <?= ($row['id_album'] == $a['id_album']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['titulo']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="actualizar" class="btn-update">Actualizar</button>
                <a href="obrasMusicales.php" class="btn-cancel">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
