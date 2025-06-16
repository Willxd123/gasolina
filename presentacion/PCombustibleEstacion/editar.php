<?php
require_once '../../negocio/NCombustibleEstacion.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NCombustibleEstacion = new NCombustibleEstacion();

$id = $_GET['id'] ?? null;
$estacion_id = $_GET['estacion_id'] ?? null;

if (!$id || !$estacion_id) {
    header('Location: index.php');
    exit;
}

$relaciones = $NCombustibleEstacion->listarPorEstacion((int)$estacion_id);
$relacion = array_filter($relaciones, fn($r) => $r['id'] == $id);
$relacion = reset($relacion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad_bombas'] ?? 0;
    $litros = $_POST['litros_disponibles'] ?? 0;
    if ($NCombustibleEstacion->editar((int)$id, (int)$cantidad, (float)$litros)) {
        header("Location: index.php?estacion_id=$estacion_id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Relación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Editar Relación</h2>
<form method="post">
    <p><strong>Tipo:</strong> <?= htmlspecialchars($relacion['tipo_combustible']) ?></p>
    <label>Cantidad de Bombas:</label>
    <input type="number" name="cantidad_bombas" value="<?= $relacion['cantidad_bombas'] ?>" min="1" required>

    <label>Litros Disponibles:</label>
    <input type="number" name="litros_disponibles" value="<?= $relacion['litros_disponibles'] ?>" min="0" step="0.01" required>

    <button type="submit">Actualizar</button>
</form>
<a href="index.php?estacion_id=<?= $estacion_id ?>">Volver</a>
</body>
</html>
