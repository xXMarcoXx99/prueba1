<?php
include 'db.php';

// Obtener todas las relaciones obra-artista con detalles
$sql = "SELECT oa.id_obra, o.titulo AS obra, 
               oa.id_artista, a.nombre AS artista, 
               oa.rol 
        FROM obra_artista oa
        INNER JOIN obras_musicales o ON oa.id_obra = o.id_obra
        INNER JOIN artistas a ON oa.id_artista = a.id_artista
        ORDER BY o.titulo ASC, a.nombre ASC";
$result = $conn->query($sql);

// Obtener lista de obras y artistas para el formulario
$obras = $conn->query("SELECT * FROM obras_musicales ORDER BY titulo ASC");
$artistas = $conn->query("SELECT * FROM artistas ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras y Artistas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Usa tu CSS aquí -->

</head>
<body>
    <h2>Relación Obra - Artista</h2>

    <!-- Formulario para agregar una relación obra-artista -->
    <form action="addObraA.php" method="POST">
        <select name="id_obra" required>
            <option value="">Selecciona una obra</option>
            <?php while ($o = $obras->fetch_assoc()): ?>
                <option value="<?= $o['id_obra'] ?>"><?= htmlspecialchars($o['titulo']) ?></option>
            <?php endwhile; ?>
        </select>

        <select name="id_artista" required>
            <option value="">Selecciona un artista</option>
            <?php while ($a = $artistas->fetch_assoc()): ?>
                <option value="<?= $a['id_artista'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
            <?php endwhile; ?>
        </select>

        <select name="rol" required>
            <option value="">Selecciona un rol</option>
            <option value="Cantante">Cantante</option>
            <option value="Intérprete">Intérprete</option>
            <option value="Compositor">Compositor</option>
        </select>

        <button type="submit" name="agregar">Agregar</button>
    </form>

    <!-- Tabla con las relaciones obra-artista -->
    <table border="1">
        <thead>
            <tr>
                <th>Obra</th>
                <th>Artista</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['obra']) ?></td>
                    <td><?= htmlspecialchars($row['artista']) ?></td>
                    <td><?= $row['rol'] ?></td>
                    <td>
                        <a href="editarObraA.php?id_obra=<?= $row['id_obra'] ?>&id_artista=<?= $row['id_artista'] ?>&rol=<?= urlencode($row['rol']) ?>">Editar</a> |
                        <a href="addObraA.php?eliminar&id_obra=<?= $row['id_obra'] ?>&id_artista=<?= $row['id_artista'] ?>&rol=<?= urlencode($row['rol']) ?>" 
                           onclick="return confirm('¿Eliminar esta relación?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button onclick="window.location.href='dashboard.php'">Regresar al inicio</button>
</body>
</html>
