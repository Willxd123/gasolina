<?php
require_once '../../negocio/NEstacion.php';
$NEstacion = new NEstacion();
$id = $_GET['id'] ?? null;
if ($id) {
    $NEstacion->eliminar($id);
}
header('Location: index.php');
exit;
?>
