<?php
// config/database.php

/**
 * Configuración de la base de datos
 * Este archivo contiene las constantes necesarias para la conexión a la base de datos
 */

define('DB_HOST', 'localhost');     // Host de la base de datos
define('DB_NOMBRE', 'estaciones_servicio');   // Nombre de la base de datos
define('DB_USUARIO', 'root');       // Usuario de MySQL (por defecto en XAMPP es root)
define('DB_CLAVE', '');             // Contraseña (por defecto en XAMPP está vacía)
define('DB_CHARSET', 'utf8');       // Charset para la conexión

/**
 * Opciones PDO adicionales si se requieren
 */
define('DB_OPCIONES', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);