<?php
function migracionTipoCombustible($conexion) {
    $sql = "CREATE TABLE IF NOT EXISTS tipo_combustible (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        descripcion VARCHAR(255),
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )";
    $conexion->exec($sql);
}
