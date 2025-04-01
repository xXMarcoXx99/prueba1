<?php
include 'db.php';

// Agregar artista
if (isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $tipo = $_POST['tipo'];
    $id_disquera = !empty($_POST['id_disquera']) ? intval($_POST['id_disquera']) : null;

    if (!empty($nombre)) {
        $stmt = $conn->prepare("INSERT INTO artistas (nombre, tipo, id_disquera) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombre, $tipo, $id_disquera);

        if ($stmt->execute()) {
            header("Location: artistas.php");
        } else {
            echo "Error al agregar el artista.";
        }
        $stmt->close();
    }
}

// Eliminar artista
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $stmt = $conn->prepare("DELETE FROM artistas WHERE id_artista = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: artistas.php");
    } else {
        echo "Error al eliminar el artista.";
    }
    $stmt->close();
}

$conn->close();
?>
