<?php
include 'db.php';

// Obtener disqueras
$sql = "SELECT * FROM disqueras ORDER BY nombre ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Disqueras</title>
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS -->
</head>
<body>
    <div class="container">
        <h2>Catálogo de Disqueras</h2>

        <!-- Formulario para agregar una nueva disquera -->
        <form action="adddisquera.php" method="POST" class="formulario">
            <input type="text" name="nombre" placeholder="Nombre de la disquera" required class="input-text">
            <input type="text" name="pais" placeholder="País" required class="input-text">
            <button type="submit" name="agregar" class="btn-agregar">Agregar</button>
        </form>

        <!-- Tabla con las disqueras -->
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>País</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_disquera'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['pais']) ?></td>
                        <td>
                            <a href="editarDisquera.php?id=<?= $row['id_disquera'] ?>" class="btn-editar">Editar</a>
                            <a href="addDisquera.php?eliminar=<?= $row['id_disquera'] ?>" class="btn-eliminar"
                               onclick="return confirm('¿Eliminar esta disquera?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button class="btn-home" onclick="window.location.href='dashboard.php'">Regresar al inicio</button>
    </div>
</body>
</html>
