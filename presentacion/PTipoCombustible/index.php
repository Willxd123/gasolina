<?php
require_once '../../negocio/NTipoCombustible.php';
require_once '../../negocio/SesionServicio.php';

$sesion = new SesionServicio();
$sesion->redirigirSiNoAutenticado('../PAutenticacion/login.php');

$NTipoCombustible = new NTipoCombustible();
$lista = $NTipoCombustible->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tipos de Combustible</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Tipos de Combustible</h2>
    <a href="crear.php">Registrar Nuevo</a>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['nombre'] ?></td>
                <td><?= $item['descripcion'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $item['id'] ?>">Editar</a> |
                    <a href="eliminar.php?id=<?= $item['id'] ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class="boton-volver" href="../panel.php">Volver al panel</a>
</body>
</html>