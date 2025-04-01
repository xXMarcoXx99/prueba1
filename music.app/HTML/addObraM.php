<?php
include 'db.php';

// Agregar obra musical
if (isset($_POST['agregar'])) {
    $titulo = trim($_POST['titulo']);
    $duracion = trim($_POST['duracion']);
    $id_genero = !empty($_POST['id_genero']) ? intval($_POST['id_genero']) : null;
    $id_album = !empty($_POST['id_album']) ? intval($_POST['id_album']) : null;

    // Validar formato MM:SS
    if (!preg_match('/^[0-9]{1,2}:[0-5][0-9]$/', $duracion)) {
        die("Error: El formato de duración debe ser MM:SS.");
    }

    if (!empty($titulo)) {
        $stmt = $conn->prepare("INSERT INTO obras_musicales (titulo, duracion, id_genero, id_album) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $titulo, $duracion, $id_genero, $id_album);

        if ($stmt->execute()) {
            header("Location: obrasMusicales.php");
        } else {
            echo "Error al agregar la obra.";
        }
        $stmt->close();
    }
}


// Eliminar obra musical
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $stmt = $conn->prepare("DELETE FROM obras_musicales WHERE id_obra = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: obrasMusicales.php");
    } else {
        echo "Error al eliminar la obra.";
    }
    $stmt->close();
}

$conn->close();
?>
