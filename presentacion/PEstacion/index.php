<?php
require_once '../../negocio/NEstacion.php';
require_once '../../negocio/SesionServicio.php';
$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NEstacion = new NEstacion();
$estaciones = $NEstacion->listarEstacionesPorUsuario();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mis Estaciones</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Mis Estaciones de Servicio</h1>
    <a class="boton" href="crear.php">Registrar Nueva Estación</a>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Acciones</th></tr>
        <?php foreach ($estaciones as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['id']) ?></td>
            <td><?= htmlspecialchars($e['nombre']) ?></td>
            <td><?= htmlspecialchars($e['direccion']) ?></td>
            <td>
                <a href="editar.php?id=<?= $e['id'] ?>">Editar</a> |
                <a href="eliminar.php?id=<?= $e['id'] ?>" onclick="return confirm('¿Eliminar estación?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a class="boton-volver" href="../panel.php">Volver al panel</a>
</body>
</html>

