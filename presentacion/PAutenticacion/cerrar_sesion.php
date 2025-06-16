<?php
require_once '../../negocio/SesionServicio.php';

$sesionServicio = new SesionServicio();
$sesionServicio->cerrarSesion();

header('Location: login.php');
exit;
