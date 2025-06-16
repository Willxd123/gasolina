<?php
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/migracion_usuarios.php';
require_once __DIR__ . '/migracion_estacion.php'; 
require_once __DIR__ . '/migracion_tipo_combustible.php'; 
require_once __DIR__ . '/migracion_combustible_estacion.php'; 

class Migrador {
    public static function ejecutar() {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        // Ejecutar todas las migraciones existentes
        migracionUsuarios($conexion);
        migracionEstacion($conexion);
        migracionTipoCombustible($conexion);
        migracionCombustibleEstacion($conexion);

        // Aquí puedes agregar más llamadas a funciones de migración
        // migracionEstaciones($conexion);
        // migracionCombustibles($conexion);
    }
}
