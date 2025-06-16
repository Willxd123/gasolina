<?php
require_once '../../negocio/NEstacion.php';
$NEstacion = new NEstacion();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    if ($NEstacion->registrar($nombre, $direccion)) {
        header('Location: index.php');
        exit;
    } else {
        $mensaje = 'Error al registrar la estación';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrar Estación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Registrar Nueva Estación</h1>
    <?php if ($mensaje): ?><p class="error"><?= $mensaje ?></p><?php endif; ?>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label>Dirección (lat, lon):</label>
        <input type="text" name="direccion" required><br>
        <button type="submit">Guardar</button>
    </form>
    <a class="boton-volver" href="index.php">Volver</a>
</body>
</html>

