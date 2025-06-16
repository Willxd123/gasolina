
<?php
require_once '../../negocio/NDisponibilidadCombustible.php';
require_once '../../negocio/NEstacion.php';
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NDisponibilidad = new NDisponibilidadCombustible();
$NEstacion = new NEstacion();
$NTipoCombustible = new NTipoCombustible();

$estaciones = $NEstacion->listarEstacionesPorUsuario();
$tipos = $NTipoCombustible->listar();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estacion_id = (int) $_POST['estacion_id'];
    $tipo_combustible_id = (int) $_POST['tipo_combustible_id'];
    $promedio = (float) $_POST['promedio_litros'];

    $cantidad = $NDisponibilidad->estimarDisponibilidad($estacion_id, $tipo_combustible_id, $promedio);
    if ($cantidad >= 0) {
        $mensaje = "Pueden abastecerse aproximadamente $cantidad vehículos.";
    } else {
        $mensaje = "Error: Ingrese un promedio válido.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Estimar Disponibilidad</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Estimar Disponibilidad de Combustible</h2>
<form method="post">
    <label>Estación:</label>
    <select name="estacion_id" required>
        <?php foreach($estaciones as $e): ?>
            <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Tipo de Combustible:</label>
    <select name="tipo_combustible_id" required>
        <?php foreach($tipos as $t): ?>
            <option value="<?= $t['id'] ?>"><?= $t['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Promedio de litros por vehículo:</label>
    <input type="number" name="promedio_litros" value="30" min="1" step="0.1" required>

    <button type="submit">Estimar</button>
</form>

<?php if ($mensaje): ?><p class="resultado"><?= $mensaje ?></p><?php endif; ?>

<a href="../panel.php">Volver al panel</a>
</body>
</html>
