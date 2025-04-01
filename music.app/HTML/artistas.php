<?php
include 'db.php';

// Obtener artistas con nombre de disquera
$sql = "SELECT a.id_artista, a.nombre, a.tipo, d.nombre AS disquera 
        FROM artistas a 
        LEFT JOIN disqueras d ON a.id_disquera = d.id_disquera 
        ORDER BY a.nombre ASC";
$result = $conn->query($sql);

// Obtener lista de disqueras para el formulario
$disqueras = $conn->query("SELECT * FROM disqueras ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Artistas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Archivo de estilos -->
</head>
<body>
    <div class="container">
        <h2>Catálogo de Artistas</h2>

        <!-- Formulario para agregar un artista -->
        <form action="addArtista.php" method="POST" class="formulario">
            <input type="text" name="nombre" placeholder="Nombre del artista" required class="input-text">
            
            <select name="tipo" required class="select-box">
                <option value="Cantante">Cantante</option>
                <option value="Intérprete">Intérprete</option>
                <option value="Compositor">Compositor</option>
            </select>

            <select name="id_disquera" class="select-box">
                <option value="">Sin disquera</option>
                <?php while ($d = $disqueras->fetch_assoc()): ?>
                    <option value="<?= $d['id_disquera'] ?>"><?= htmlspecialchars($d['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="agregar" class="btn-agregar">Agregar</button>
        </form>

        <!-- Tabla con los artistas -->
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Disquera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_artista'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= $row['tipo'] ?></td>
                        <td><?= $row['disquera'] ?: 'Sin disquera' ?></td>
                        <td>
                            <a href="editarArtista.php?id=<?= $row['id_artista'] ?>" class="btn-editar">Editar</a>
                            <a href="addArtista.php?eliminar=<?= $row['id_artista'] ?>" class="btn-eliminar"
                               onclick="return confirm('¿Eliminar este artista?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button class="btn-home" onclick="window.location.href='dashboard.php'">Regresar al inicio</button>
    </div>
</body>
</html>
