<?php

require_once __DIR__ . '/../datos/DEstacion.php';
require_once __DIR__ . '/../negocio/SesionServicio.php';
// Ejecuta la creación de la tabla si no existe


class NEstacion {
    private DEstacion $DEstacion;
    private SesionServicio $SesionServicio;

    public function __construct() {
        $this->DEstacion = new DEstacion();
        $this->SesionServicio = new SesionServicio();
    }

    public function listarEstacionesPorUsuario(): array {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        return $this->DEstacion->obtenerPorUsuarioId($usuario['id']);
    }

    public function registrar(string $nombre, string $direccion): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DEstacion->setNombre($nombre);
        $this->DEstacion->setDireccion($direccion);
        $this->DEstacion->setUsuarioId($usuario['id']);
        return $this->DEstacion->registrar();
    }

    public function editar(int $id, string $nombre, string $direccion): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DEstacion->setId($id);
        $this->DEstacion->setNombre($nombre);
        $this->DEstacion->setDireccion($direccion);
        $this->DEstacion->setUsuarioId($usuario['id']);
        return $this->DEstacion->editar();
    }

    public function eliminar(int $id): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DEstacion->setId($id);
        $this->DEstacion->setUsuarioId($usuario['id']);
        return $this->DEstacion->eliminar();
    }
}