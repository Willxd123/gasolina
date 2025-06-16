<?php
// presentacion/includes/header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estaciones de Servicio</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <h1>Estaciones de Servicio</h1>
            <nav class="navegacion">
                <ul>
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <li><a href="panel.php">Panel</a></li>
                        <li><a href="PAutenticacion/cerrar_sesion.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <!-- <li><a href="PAutenticacion/login.php">Iniciar Sesión</a></li> -->
                        <!-- <li><a href="PAutenticacion/registro.php">Registrarse</a></li> -->
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="contenedor">
        <div class="mensajes"></div>