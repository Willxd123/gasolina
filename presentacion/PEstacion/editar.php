<?php
require_once '../../negocio/NEstacion.php';
$NEstacion = new NEstacion();


$id = $_GET['id'] ?? null;
$mensaje = '';
$tipoMensaje = '';
$estacion = [];

if (!$id) {
    header('Location: index.php');
    exit;
}

$lista = $NEstacion->listarEstacionesPorUsuario();
$actual = array_filter($lista, fn($e) => $e['id'] == $id);
$actual = reset($actual);

// Inicializar stacks si no existen
if (!isset($_SESSION['undo_stack'])) $_SESSION['undo_stack'] = [];
if (!isset($_SESSION['redo_stack'])) $_SESSION['redo_stack'] = [];

// Estado base
$estacion['nombre'] = $actual['nombre'];
$estacion['direccion'] = $actual['direccion'];

// GUARDAR TEMPORAL
if (isset($_POST['guardar_temporal'])) {
    $_SESSION['undo_stack'][] = [
        'nombre' => $_POST['nombre'],
        'direccion' => $_POST['direccion']
    ];
    $_SESSION['redo_stack'] = []; // Al guardar, se limpia la pila de redo
    $mensaje = 'Estado guardado en memento';
    $tipoMensaje = 'success';
    $estacion['nombre'] = $_POST['nombre'];
    $estacion['direccion'] = $_POST['direccion'];
}
// DESHACER (UNDO)
elseif (isset($_POST['deshacer'])) {
    if (!empty($_SESSION['undo_stack'])) {
        $currentState = [
            'nombre' => $_POST['nombre'],
            'direccion' => $_POST['direccion']
        ];
        $_SESSION['redo_stack'][] = $currentState;
        $prev = array_pop($_SESSION['undo_stack']);
        $estacion = $prev;
        $mensaje = 'Estado restaurado desde memento';
        $tipoMensaje = 'success';
    } else {
        $mensaje = 'No hay estados anteriores para deshacer';
        $tipoMensaje = 'warning';
        $estacion['nombre'] = $_POST['nombre'];
        $estacion['direccion'] = $_POST['direccion'];
    }
}
// REHACER (REDO)
elseif (isset($_POST['rehacer'])) {
    if (!empty($_SESSION['redo_stack'])) {
        $currentState = [
            'nombre' => $_POST['nombre'],
            'direccion' => $_POST['direccion']
        ];
        $_SESSION['undo_stack'][] = $currentState;
        $redo = array_pop($_SESSION['redo_stack']);
        $estacion = $redo;
        $mensaje = 'Estado rehecho';
        $tipoMensaje = 'success';
    } else {
        $mensaje = 'No hay estados para rehacer';
        $tipoMensaje = 'warning';
        $estacion['nombre'] = $_POST['nombre'];
        $estacion['direccion'] = $_POST['direccion'];
    }
}
// ACTUALIZAR DEFINITIVO
elseif (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    if ($NEstacion->editar($id, $nombre, $direccion)) {
        unset($_SESSION['undo_stack']);
        unset($_SESSION['redo_stack']);
        header('Location: index.php');
        exit;
    } else {
        $mensaje = 'Error al actualizar en la base de datos';
        $tipoMensaje = 'error';
        $estacion['nombre'] = $_POST['nombre'];
        $estacion['direccion'] = $_POST['direccion'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estación - Patrón Memento</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="memento-container">
        <div class="memento-header">
            <h1>Editar Estación</h1>
            <div class="memento-subtitle">Patrón Memento - Gestión de Estados</div>
        </div>

        <div class="memento-content">
            <div class="editor-panel">
                <div class="pattern-info">
                    <h3>Patrón Memento</h3>
                    <p>Permite capturar y restaurar el estado interno de un objeto sin violar su encapsulación. Usa las pilas de undo/redo para navegar entre estados.</p>
                </div>

                <?php if ($mensaje): ?>
                <div class="message <?= $tipoMensaje ?>">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-section">
                        <label for="nombre">Nombre de la Estación:</label>
                        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($estacion['nombre']) ?>" required>
                    </div>

                    <div class="form-section">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($estacion['direccion']) ?>" required>
                    </div>

                    <div class="memento-actions">
                        <button type="submit" name="guardar_temporal" class="memento-btn btn-save">
                            Crear Memento
                        </button>
                        <button type="submit" name="deshacer" class="memento-btn btn-undo" <?= empty($_SESSION['undo_stack']) ? 'disabled' : '' ?>>
                            Deshacer (Undo)
                        </button>
                        <button type="submit" name="rehacer" class="memento-btn btn-redo" <?= empty($_SESSION['redo_stack']) ? 'disabled' : '' ?>>
                            Rehacer (Redo)
                        </button>
                        <button type="submit" name="actualizar" class="memento-btn btn-update">
                            Guardar Definitivo
                        </button>
                    </div>
                </form>

                <a href="index.php" class="back-link">← Volver al Listado</a>
            </div>

            <div class="state-panel">
                <div class="current-state">
                    <h3>Estado Actual</h3>
                    <div class="state-display" id="current-state-display">
                        <strong>Nombre:</strong> <?= htmlspecialchars($estacion['nombre']) ?><br>
                        <strong>Dirección:</strong> <?= htmlspecialchars($estacion['direccion']) ?>
                    </div>
                </div>

                <div class="stack-section">
                    <div class="stack-title">
                        Pila Undo
                        <span class="stack-count"><?= count($_SESSION['undo_stack']) ?></span>
                    </div>
                    <div class="stack-items">
                        <?php if (empty($_SESSION['undo_stack'])): ?>
                            <div class="stack-empty">Sin estados guardados</div>
                        <?php else: ?>
                            <?php foreach (array_reverse($_SESSION['undo_stack']) as $index => $state): ?>
                                <div class="stack-item">
                                    <strong>Estado <?= count($_SESSION['undo_stack']) - $index ?>:</strong><br>
                                    <?= htmlspecialchars($state['nombre']) ?> | <?= htmlspecialchars($state['direccion']) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="stack-section">
                    <div class="stack-title">
                        Pila Redo
                        <span class="stack-count"><?= count($_SESSION['redo_stack']) ?></span>
                    </div>
                    <div class="stack-items">
                        <?php if (empty($_SESSION['redo_stack'])): ?>
                            <div class="stack-empty">Sin estados para rehacer</div>
                        <?php else: ?>
                            <?php foreach (array_reverse($_SESSION['redo_stack']) as $index => $state): ?>
                                <div class="stack-item">
                                    <strong>Estado <?= count($_SESSION['redo_stack']) - $index ?>:</strong><br>
                                    <?= htmlspecialchars($state['nombre']) ?> | <?= htmlspecialchars($state['direccion']) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nombreInput = document.getElementById('nombre');
            const direccionInput = document.getElementById('direccion');
            const currentStateDisplay = document.getElementById('current-state-display');

            function updateCurrentState() {
                currentStateDisplay.innerHTML = `
                    <strong>Nombre:</strong> ${nombreInput.value}<br>
                    <strong>Dirección:</strong> ${direccionInput.value}
                `;
            }

            nombreInput.addEventListener('input', updateCurrentState);
            direccionInput.addEventListener('input', updateCurrentState);
        });
    </script>
</body>
</html>