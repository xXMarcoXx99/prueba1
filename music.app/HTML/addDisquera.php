<?php
include 'db.php';

// Agregar disquera
if (isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $pais = trim($_POST['pais']);

    if (!empty($nombre)) {
        $stmt = $conn->prepare("INSERT INTO disqueras (nombre, pais) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $pais);

        if ($stmt->execute()) {
            header("Location: disqueras.php");
        } else {
            echo "Error al agregar la disquera.";
        }
        $stmt->close();
    }
}

// Eliminar disquera
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $stmt = $conn->prepare("DELETE FROM disqueras WHERE id_disquera = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: disqueras.php");
    } else {
        echo "Error al eliminar la disquera.";
    }
    $stmt->close();
}

$conn->close();
?>
