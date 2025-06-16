<?php
function migracionCombustibleEstacion(PDO $conexion) {
    $sql = "CREATE TABLE IF NOT EXISTS combustible_estacion (
        id INT AUTO_INCREMENT PRIMARY KEY,
        estacion_id INT NOT NULL,
        tipo_combustible_id INT NOT NULL,
        cantidad_bombas INT NOT NULL,
        litros_disponibles FLOAT NOT NULL DEFAULT 0,
        FOREIGN KEY (estacion_id) REFERENCES estacion(id),
        FOREIGN KEY (tipo_combustible_id) REFERENCES tipo_combustible(id)
    )";
    $conexion->exec($sql);
}
