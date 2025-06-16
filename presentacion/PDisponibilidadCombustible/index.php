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

$resultado = null;
$tipoNombreCompleto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estacion_id = (int) $_POST['estacion_id'];
    $tipo_combustible_id = (int) $_POST['tipo_combustible_id'];
    $promedio = (float) $_POST['promedio_litros'];

    // Obtener el nombre del tipo de combustible para la capa de negocio
    foreach($tipos as $t) {
        if($t['id'] == $tipo_combustible_id) {
            $tipoNombreCompleto = $t['nombre'];
            break;
        }
    }

    // La capa de presentación solo llama a la capa de negocio
    // La lógica del patrón Strategy está completamente en la capa de negocio
    $resultado = $NDisponibilidad->estimarDisponibilidad($estacion_id, $tipo_combustible_id, $promedio, $tipoNombreCompleto);
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

<div class="patron-info">
    <h3>🎯 Patrón Strategy en Acción</h3>
    <p>Cada tipo de combustible utiliza su algoritmo específico de cálculo optimizado</p>
</div>

<form method="post">
    <div class="form-section">
        <label>Estación:</label>
        <select name="estacion_id" required>
            <?php foreach($estaciones as $e): ?>
                <option value="<?= $e['id'] ?>" <?= (isset($_POST['estacion_id']) && $_POST['estacion_id'] == $e['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-section combustible-section">
        <label>Tipo de Combustible:</label>
        <select name="tipo_combustible_id" required>
            <?php foreach($tipos as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($_POST['tipo_combustible_id']) && $_POST['tipo_combustible_id'] == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="help-text important">
            💡 Cada tipo usa un algoritmo diferente para el cálculo
        </div>
    </div>

    <div class="form-section">
        <label>Promedio de litros por vehículo (opcional):</label>
        <input type="number" name="promedio_litros" value="<?= isset($_POST['promedio_litros']) ? htmlspecialchars($_POST['promedio_litros']) : '0' ?>" min="0" step="0.1">
        <div class="help-text">
            Deje en 0 para usar el promedio estándar optimizado del tipo de combustible
        </div>
    </div>

    <button type="submit">🔍 Calcular con Algoritmo Específico</button>
</form>

<?php if ($resultado !== null): ?>
    <?php if ($resultado['exito']): ?>
    <div class="resultado-container">
        <div class="resultado-header">
            <h3>✅ Resultado del Cálculo</h3>
        </div>
        <div class="resultado-body">
            <div class="resultado-principal">
                🚗 <?= $resultado['cantidad'] ?> vehículos
            </div>
            <p>Con el combustible tipo <strong>'<?= htmlspecialchars($tipoNombreCompleto) ?>'</strong> disponible</p>
            
            <?php if (!empty($resultado['algoritmo_info'])): ?>
            <div class="algoritmo-info">
                <h4>🧠 Algoritmo Utilizado:</h4>
                <p><?= htmlspecialchars($resultado['algoritmo_info']) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($resultado['estrategia_usada'])): ?>
            <div class="algoritmo-info">
                <h4>⚡ Estrategia Ejecutada:</h4>
                <p><code><?= htmlspecialchars($resultado['estrategia_usada']) ?></code></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="error">
        ❌ <?= htmlspecialchars($resultado['mensaje']) ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="tipos-info">
    <div class="tipos-info-header">
        <h3>📋 Algoritmos por Tipo de Combustible</h3>
    </div>
    <div class="tipo-item">
        <div class="icon tipo-gasolina"></div>
        <div class="info">
            <div class="nombre">🚗 Gasolina</div>
            <p class="descripcion">Promedio: 27.5L por vehículo • Optimizado para autos ligeros</p>
        </div>
    </div>
    <div class="tipo-item">
        <div class="icon tipo-diesel"></div>
        <div class="info">
            <div class="nombre">🚛 Diesel</div>
            <p class="descripcion">Promedio: 45L por vehículo • Factor 0.9 para vehículos pesados</p>
        </div>
    </div>
    <div class="tipo-item">
        <div class="icon tipo-gnv"></div>
        <div class="info">
            <div class="nombre">🚐 GNV</div>
            <p class="descripcion">Promedio: 17.5 m³ por vehículo • Optimizado para gas natural</p>
        </div>
    </div>
</div>

<a href="../panel.php" class="boton-volver">← Volver al panel</a>
</body>
</html>