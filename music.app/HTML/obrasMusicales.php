<?php
include 'db.php';

// Obtener obras con género y álbum
$sql = "SELECT o.id_obra, o.titulo, o.duracion, 
               g.nombre AS genero, 
               a.titulo AS album 
        FROM obras_musicales o
        LEFT JOIN generos g ON o.id_genero = g.id_genero
        LEFT JOIN albumes a ON o.id_album = a.id_album
        ORDER BY a.titulo ASC, o.titulo ASC";
$result = $conn->query($sql);

// Obtener lista de géneros y álbumes para el formulario
$generos = $conn->query("SELECT * FROM generos ORDER BY nombre ASC");
$albumes = $conn->query("SELECT * FROM albumes ORDER BY titulo ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras Musicales</title>
    <link rel="stylesheet" href="styles.css"> <!-- Usa tu CSS aquí -->

</head>
<body>
    <h2>Obras Musicales</h2>

    <!-- Formulario para agregar una obra musical -->
        <form action="addObraM.php" method="POST">
        <input type="text" name="titulo" placeholder="Título de la obra" required>
        <input type="text" name="duracion" placeholder="Duración (MM:SS)" pattern="^[0-9]{1,2}:[0-5][0-9]$" required>
        <select name="id_genero">
            <option value="">Sin género</option>
            <?php while ($g = $generos->fetch_assoc()): ?>
                <option value="<?= $g['id_genero'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
            <?php endwhile; ?>
        </select>
        <select name="id_album">
            <option value="">Sin álbum</option>
            <?php while ($a = $albumes->fetch_assoc()): ?>
                <option value="<?= $a['id_album'] ?>"><?= htmlspecialchars($a['titulo']) ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="agregar">Agregar</button>
    </form>


    <!-- Tabla con las obras musicales -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Duración</th>
                <th>Género</th>
                <th>Álbum</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_obra'] ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= $row['duracion'] ?></td>
                    <td><?= $row['genero'] ?: 'Sin género' ?></td>
                    <td><?= $row['album'] ?: 'Sin álbum' ?></td>
                    <td>
                        <a href="editarObraM.php?id=<?= $row['id_obra'] ?>">Editar</a> |
                        <a href="addObraM.php?eliminar=<?= $row['id_obra'] ?>" onclick="return confirm('¿Eliminar esta obra?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button class="btn-home" onclick="window.location.href='dashboard.php'">Regresar al inicio</button>

</body>
</html>
