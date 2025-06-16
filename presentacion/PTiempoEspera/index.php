<?php
require_once '../../negocio/NTiempoEspera.php';
require_once '../../negocio/NEstacion.php';
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NTiempoEspera = new NTiempoEspera();
$NEstacion = new NEstacion();
$NTipoCombustible = new NTipoCombustible();

$estaciones = $NEstacion->listarEstacionesPorUsuario();
$tiposCombustible = $NTipoCombustible->listar();

$mensaje = '';
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estacion_id = (int)$_POST['estacion_id'];
    $tipo_combustible_id = (int)$_POST['tipo_combustible_id'];
    $distancia = (float)$_POST['distancia'];

    if ($distancia > 0) {
        $resultado = $NTiempoEspera->calcularEspera($estacion_id, $tipo_combustible_id, $distancia);
        if ($resultado == -1) {
            $mensaje = "No se encontró cantidad de bombas.";
        }
    } else {
        $mensaje = "Ingrese una distancia válida.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calcular Tiempo de Espera</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Calcular Tiempo de Espera en Fila</h2>
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

        <label>Distancia de la Fila (m):</label>
        <input type="number" name="distancia" step="0.01" required min="1">

        <button type="submit">Calcular Espera</button>
    </form>

    <?php if ($resultado !== null && $resultado !== -1): ?>
        <p class="resultado">Tiempo estimado de espera: <strong><?= $resultado ?> minutos</strong></p>
    <?php endif; ?>

    <a href="../panel.php">Volver al panel</a>
</body>
</html>
