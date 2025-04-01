<?php
include 'db.php';

// Agregar género
if (isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        $stmt = $conn->prepare("INSERT INTO generos (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            header("Location: generos.php");
        } else {
            echo "Error al agregar el género.";
        }
        $stmt->close();
    }
}

// Eliminar género
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $stmt = $conn->prepare("DELETE FROM generos WHERE id_genero = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: generos.php");
    } else {
        echo "Error al eliminar el género.";
    }
    $stmt->close();
}

$conn->close();
?>
