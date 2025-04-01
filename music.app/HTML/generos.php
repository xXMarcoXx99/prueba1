<?php
include 'db.php';

// Obtener géneros
$sql = "SELECT * FROM generos ORDER BY nombre ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Géneros</title>
    <link rel="stylesheet" href="styles.css"> <!-- Usa tu CSS aquí -->
</head>
<body>
    <div class="container">
        <h2>Catálogo de Géneros</h2>

        <!-- Formulario para agregar un nuevo género -->
        <form action="addgenero.php" method="POST" class="formulario">
            <input type="text" name="nombre" placeholder="Nombre del género" required class="input-text">
            <button type="submit" name="agregar" class="btn-agregar">Agregar</button>
        </form>

        <!-- Tabla con los géneros -->
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_genero'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td>
                            <a href="editargenero.php?id=<?= $row['id_genero'] ?>" class="btn-editar">Editar</a>
                            <a href="addgenero.php?eliminar=<?= $row['id_genero'] ?>" class="btn-eliminar" 
                               onclick="return confirm('¿Eliminar este género?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button class="btn-home" onclick="window.location.href='dashboard.php'">Regresar al inicio</button>
    </div>
</body>
</html>
