<?php
require_once __DIR__ . '/../datos/DTipoCombustible.php';
require_once __DIR__ . '/../negocio/SesionServicio.php';

class NTipoCombustible {
    private DTipoCombustible $DTipoCombustible;
    private SesionServicio $SesionServicio;

    public function __construct() {
        $this->DTipoCombustible = new DTipoCombustible();
        $this->SesionServicio = new SesionServicio();
    }

    public function listar(): array {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DTipoCombustible->setUsuarioId($usuario['id']);
        return $this->DTipoCombustible->obtenerTodos();
    }

    public function registrar(string $nombre, ?string $descripcion): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DTipoCombustible->setNombre($nombre);
        $this->DTipoCombustible->setDescripcion($descripcion);
        $this->DTipoCombustible->setUsuarioId($usuario['id']);
        return $this->DTipoCombustible->registrar();
    }

    public function editar(int $id, string $nombre, ?string $descripcion): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DTipoCombustible->setId($id);
        $this->DTipoCombustible->setNombre($nombre);
        $this->DTipoCombustible->setDescripcion($descripcion);
        $this->DTipoCombustible->setUsuarioId($usuario['id']);
        return $this->DTipoCombustible->editar();
    }

    public function eliminar(int $id): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DTipoCombustible->setId($id);
        $this->DTipoCombustible->setUsuarioId($usuario['id']);
        return $this->DTipoCombustible->eliminar();
    }
}
