<?php
include 'db.php';

// Agregar álbum
if (isset($_POST['agregar'])) {
    $titulo = trim($_POST['titulo']);
    $anio = intval($_POST['anio']);
    $id_disquera = !empty($_POST['id_disquera']) ? intval($_POST['id_disquera']) : null;

    if (!empty($titulo) && $anio >= 1900 && $anio <= date('Y')) {
        $stmt = $conn->prepare("INSERT INTO albumes (titulo, anio, id_disquera) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $titulo, $anio, $id_disquera);

        if ($stmt->execute()) {
            header("Location: albumes.php");
        } else {
            echo "Error al agregar el álbum.";
        }
        $stmt->close();
    }
}

// Eliminar álbum
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);

    $stmt = $conn->prepare("DELETE FROM albumes WHERE id_album = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: albumes.php");
    } else {
        echo "Error al eliminar el álbum.";
    }
    $stmt->close();
}

$conn->close();
?>
