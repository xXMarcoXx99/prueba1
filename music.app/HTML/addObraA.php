<?php
include 'db.php';

// Agregar relación obra-artista
if (isset($_POST['agregar'])) {
    $id_obra = intval($_POST['id_obra']);
    $id_artista = intval($_POST['id_artista']);
    $rol = $_POST['rol'];

    $stmt = $conn->prepare("INSERT INTO obra_artista (id_obra, id_artista, rol) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id_obra, $id_artista, $rol);

    if ($stmt->execute()) {
        header("Location: obrasArtistas.php");
    } else {
        echo "Error al agregar la relación.";
    }
    $stmt->close();
}

// Eliminar relación obra-artista
if (isset($_GET['eliminar'])) {
    $id_obra = intval($_GET['id_obra']);
    $id_artista = intval($_GET['id_artista']);
    $rol = $_GET['rol'];

    $stmt = $conn->prepare("DELETE FROM obra_artista WHERE id_obra = ? AND id_artista = ? AND rol = ?");
    $stmt->bind_param("iis", $id_obra, $id_artista, $rol);

    if ($stmt->execute()) {
        header("Location: obrasArtistas.php");
    } else {
        echo "Error al eliminar la relación.";
    }
    $stmt->close();
}

$conn->close();
?>
