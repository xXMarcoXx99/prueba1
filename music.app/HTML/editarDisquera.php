<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM disqueras WHERE id_disquera = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $pais = trim($_POST['pais']);

    if (!empty($nombre)) {
        $stmt = $conn->prepare("UPDATE disqueras SET nombre = ?, pais = ? WHERE id_disquera = ?");
        $stmt->bind_param("ssi", $nombre, $pais, $id);

        if ($stmt->execute()) {
            header("Location: disqueras.php");
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
    <title>Editar Disquera</title>
    <link rel="stylesheet" href="stylesE.css"> <!-- Enlazamos el CSS -->

</head>
<body>
        <div class="container">
                <h2>Editar Disquera</h2>
                <div class="form-container">
                    
                    <form action="editarDisquera.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id_disquera'] ?>">
                        <input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" required>
                        <input type="text" name="pais" value="<?= htmlspecialchars($row['pais']) ?>">
                        <button type="submit" name="actualizar">Actualizar</button>
                        <a href="disqueras.php" class="btn-cancel">Cancelar</a>

                    </form>
                </div>
        </div>
</body>
</html>
