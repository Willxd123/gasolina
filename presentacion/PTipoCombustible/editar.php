<?php
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';
$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');
$NTipoCombustible = new NTipoCombustible();
$lista = $NTipoCombustible->listar();

$id = $_GET['id'] ?? null;
$actual = array_filter($lista, fn($i) => $i['id'] == $id);
$actual = reset($actual);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'] ?? null;
    if ($NTipoCombustible->editar($id, $nombre, $descripcion)) {
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Editar Tipo</title><link rel="stylesheet" href="estilos.css"></head>
<body>
    <h2>Editar Tipo de Combustible</h2>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $actual['nombre'] ?>" required>
        <label>Descripción:</label>
        <textarea name="descripcion"><?= $actual['descripcion'] ?></textarea>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>

