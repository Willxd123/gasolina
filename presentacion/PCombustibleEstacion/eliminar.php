<?php
require_once '../../negocio/NCombustibleEstacion.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NCombustibleEstacion = new NCombustibleEstacion();

$id = $_GET['id'] ?? null;
$estacion_id = $_GET['estacion_id'] ?? null;

if ($id && $estacion_id) {
    $NCombustibleEstacion->eliminar((int)$id);
}

header("Location: index.php?estacion_id=$estacion_id");
exit;
