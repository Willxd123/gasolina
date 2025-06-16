<?php
require_once '../negocio/SesionServicio.php';

$sesionServicio = new SesionServicio();
$sesionServicio->redirigirSiNoAutenticado('PAutenticacion/login.php');
$usuario = $sesionServicio->obtenerUsuarioActual();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        .panel-usuario {
            padding: 20px;
            background: #f9f9f9;
        }

        .panel-usuario h2 {
            color: #2c3e50;
        }

        .acciones {
            margin-top: 20px;
        }

        .acciones ul {
            list-style-type: none;
            padding: 0;
        }

        .acciones li {
            margin-bottom: 10px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .boton:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="panel-usuario">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
        <p>Desde aquí podrás administrar las estaciones de servicio y los tipos de combustible registrados por ti.</p>

        <div class="acciones">
            <h3>Accesos rápidos</h3>
            <ul>
                <li><a href="PEstacion/index.php" class="boton">Gestionar Estaciones</a></li>
                <li><a href="PTipoCombustible/index.php" class="boton">Gestionar Tipos de Combustible</a></li>
                <li><a href="PCombustibleEstacion/index.php" class="boton">Gestionar Combustible en Estación</a></li>
                <li><a href="PTiempoEspera/index.php" class="boton">Calcular Tiempo de Espera</a></li>
                <li><a href="PDisponibilidadCombustible/index.php" class="boton">Disponibilidad de Combustible</a></li>
            </ul>
        </div>
    </div> 

    <?php include 'includes/footer.php'; ?>
</body>

</html>