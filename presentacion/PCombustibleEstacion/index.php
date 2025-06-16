<?php
require_once '../../negocio/NCombustibleEstacion.php';
require_once '../../negocio/NEstacion.php';
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';

$SesionServicio = new SesionServicio();
$SesionServicio->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$usuario = $SesionServicio->obtenerUsuarioActual();
$NEstacion = new NEstacion();
$estaciones = $NEstacion->listarEstacionesPorUsuario();

$estacionSeleccionada = $_GET['estacion_id'] ?? ($estaciones[0]['id'] ?? null);

$NCombustibleEstacion = new NCombustibleEstacion();
$NTipoCombustible = new NTipoCombustible();
$tipos = $NTipoCombustible->listar();
$relaciones = $estacionSeleccionada ? $NCombustibleEstacion->listarPorEstacion((int)$estacionSeleccionada) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Combustible por Estación</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Gestionar Combustible en Estación</h2>

<form method="get">
    <label>Estación:</label>
    <select name="estacion_id" onchange="this.form.submit()">
        <?php foreach($estaciones as $e): ?>
            <option value="<?= $e['id'] ?>" <?= $e['id'] == $estacionSeleccionada ? 'selected' : '' ?>>
                <?= $e['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($estacionSeleccionada): ?>
<form method="post" action="crear.php">
    <input type="hidden" name="estacion_id" value="<?= $estacionSeleccionada ?>">
    <label>Tipo de Combustible:</label>
    <select name="tipo_combustible_id" required>
        <?php foreach ($tipos as $t): ?>
            <option value="<?= $t['id'] ?>"><?= $t['nombre'] ?></option>
        <?php endforeach; ?>
    </select>
    <label>Cantidad de Bombas:</label>
    <input type="number" name="cantidad_bombas" required min="1">
    <label>Litros Disponibles:</label>
    <input type="number" name="litros_disponibles" required min="0" step="0.01">
    <button type="submit">Asignar</button>
</form>

<table>
    <thead>
        <tr>
            <th>Tipo de Combustible</th>
            <th>Bombas</th>
            <th>Litros</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($relaciones as $r): ?>
        <tr>
            <td><?= $r['tipo_combustible'] ?></td>
            <td><?= $r['cantidad_bombas'] ?></td>
            <td><?= $r['litros_disponibles'] ?></td>
            <td>
                <a href="editar.php?id=<?= $r['id'] ?>&estacion_id=<?= $estacionSeleccionada ?>">Editar</a>
                <a href="eliminar.php?id=<?= $r['id'] ?>&estacion_id=<?= $estacionSeleccionada ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<a class="boton-volver" href="../panel.php">Volver al panel</a>
</body>
</html>
