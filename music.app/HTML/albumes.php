<?php
include 'db.php';

// Obtener álbumes con nombre de disquera
$sql = "SELECT a.id_album, a.titulo, a.anio, d.nombre AS disquera 
        FROM albumes a 
        LEFT JOIN disqueras d ON a.id_disquera = d.id_disquera 
        ORDER BY a.anio DESC, a.titulo ASC";
$result = $conn->query($sql);

// Obtener lista de disqueras para el formulario
$disqueras = $conn->query("SELECT * FROM disqueras ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Álbumes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Usa tu CSS aquí -->
</head>
<body>
    <h2>Catálogo de Álbumes</h2>

    <!-- Formulario para agregar un álbum -->
    <form action="addAlbum.php" method="POST">
        <input type="text" name="titulo" placeholder="Título del álbum" required>
        <input type="number" name="anio" placeholder="Año de lanzamiento" min="1900" max="<?= date('Y') ?>" required>
        <select name="id_disquera">
            <option value="">Sin disquera</option>
            <?php while ($d = $disqueras->fetch_assoc()): ?>
                <option value="<?= $d['id_disquera'] ?>"><?= htmlspecialchars($d['nombre']) ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="agregar">Agregar</button>
    </form>

    <!-- Tabla con los álbumes -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Año</th>
                <th>Disquera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_album'] ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= $row['anio'] ?></td>
                    <td><?= $row['disquera'] ?: 'Sin disquera' ?></td>
                    <td>
                        <a href="editarAlbum.php?id=<?= $row['id_album'] ?>">Editar</a> |
                        <a href="addAlbum.php?eliminar=<?= $row['id_album'] ?>" onclick="return confirm('¿Eliminar este álbum?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button class="btn-home" onclick="window.location.href='dashboard.php'">Regresar al inicio</button>


</body>
</html>
