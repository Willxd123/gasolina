<?php
require_once '../../negocio/SesionServicio.php';
require_once '../../negocio/NTipoCombustible.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');
$NTipoCombustible = new NTipoCombustible();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'] ?? null;
    if ($NTipoCombustible->registrar($nombre, $descripcion)) {
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Registrar Tipo</title><link rel="stylesheet" href="estilos.css"></head>
<body>
    <h2>Registrar Tipo de Combustible</h2>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>

