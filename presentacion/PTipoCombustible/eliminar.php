<?php
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';
$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');
$NTipoCombustible = new NTipoCombustible();

$id = $_GET['id'] ?? null;
if ($id) {
    $NTipoCombustible->eliminar($id);
}
header('Location: index.php');
exit;
?>
