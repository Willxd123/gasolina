<?php
function migracionEstacion($conexion) {
    $sql = "CREATE TABLE IF NOT EXISTS estacion (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        direccion VARCHAR(255) NOT NULL,
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )";
    $conexion->query($sql);
}
