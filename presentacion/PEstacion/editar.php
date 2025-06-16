<?php
require_once '../../negocio/NEstacion.php';
$NEstacion = new NEstacion();
$id = $_GET['id'] ?? null;
$mensaje = '';

if (!$id) {
    header('Location: index.php');
    exit;
}

$lista = $NEstacion->listarEstacionesPorUsuario();
$estacion = array_filter($lista, fn($e) => $e['id'] == $id);
$estacion = reset($estacion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    if ($NEstacion->editar($id, $nombre, $direccion)) {
        header('Location: index.php');
        exit;
    } else {
        $mensaje = 'Error al actualizar la estación';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Estación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Editar Estación</h1>
    <?php if ($mensaje): ?><p class="error"><?= $mensaje ?></p><?php endif; ?>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($estacion['nombre']) ?>" required><br>
        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= htmlspecialchars($estacion['direccion']) ?>" required><br>
        <button type="submit">Actualizar</button>
    </form>
    <a class="boton-volver" href="index.php">Volver</a>
</body>
</html>
