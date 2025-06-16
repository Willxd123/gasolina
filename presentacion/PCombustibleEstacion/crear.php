<?php
require_once '../../negocio/NCombustibleEstacion.php';
require_once '../../negocio/NEstacion.php';
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NCombustibleEstacion = new NCombustibleEstacion();
$NEstacion = new NEstacion();
$NTipoCombustible = new NTipoCombustible();

$estaciones = $NEstacion->listarEstacionesPorUsuario();
$tiposCombustible = $NTipoCombustible->listar();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estacion_id = $_POST['estacion_id'];
    $tipo_combustible_id = $_POST['tipo_combustible_id'];
    $cantidad_bombas = $_POST['cantidad_bombas'];
    $litros = $_POST['litros_disponibles'];

    if ($NCombustibleEstacion->registrar((int)$estacion_id, (int)$tipo_combustible_id, (int)$cantidad_bombas, (float)$litros)) {
        header('Location: index.php');
        exit;
    } else {
        $mensaje = 'Ya existe esta relación o hubo un error.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asignar Combustible a Estación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Asignar Tipo de Combustible a Estación</h2>
<?php if ($mensaje): ?><p class="error"><?= $mensaje ?></p><?php endif; ?>

<form method="post">
    <label>Estación:</label>
    <select name="estacion_id" required>
        <?php foreach ($estaciones as $e): ?>
            <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Tipo de Combustible:</label>
    <select name="tipo_combustible_id" required>
        <?php foreach ($tiposCombustible as $t): ?>
            <option value="<?= $t['id'] ?>"><?= $t['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Cantidad de Bombas:</label>
    <input type="number" name="cantidad_bombas" required min="1">

    <label>Litros Disponibles:</label>
    <input type="number" name="litros_disponibles" required min="0" step="0.01">

    <button type="submit">Guardar</button>
</form>
<a href="index.php">Volver</a>
</body>
</html>
