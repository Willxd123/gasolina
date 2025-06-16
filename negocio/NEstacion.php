<?php

require_once __DIR__ . '/../datos/DEstacion.php';
require_once __DIR__ . '/../negocio/SesionServicio.php';
// Ejecuta la creación de la tabla si no existe

require_once __DIR__ . '/patrones/Memento/EstacionOriginator.php';
require_once __DIR__ . '/patrones/Memento/EstacionCaretaker.php';
require_once __DIR__ . '/patrones/Memento/EstacionMemento.php';
class NEstacion
{
    private DEstacion $DEstacion;
    private SesionServicio $SesionServicio;
    // MEMENTO
    private EstacionOriginator $originator;
    private EstacionCaretaker $caretaker;
    
    public function __construct()
    {
        $this->DEstacion = new DEstacion();
        $this->SesionServicio = new SesionServicio();
        
        $this->originator = new EstacionOriginator();
        $this->caretaker = new EstacionCaretaker();
    }

    public function listarEstacionesPorUsuario(): array
    {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        return $this->DEstacion->obtenerPorUsuarioId($usuario['id']);
    }

    public function registrar(string $nombre, string $direccion): bool
    {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DEstacion->setNombre($nombre);
        $this->DEstacion->setDireccion($direccion);
        $this->DEstacion->setUsuarioId($usuario['id']);
        return $this->DEstacion->registrar();
    }

    public function editar(int $id, string $nombre, string $direccion): bool {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();

        // Guardar estado anterior
        $actuales = $this->DEstacion->obtenerPorUsuarioId($usuario['id']);
        $actual = array_filter($actuales, fn($e) => $e['id'] == $id);
        $actual = reset($actual);
        if ($actual) {
            $this->originator->setState($actual['nombre'], $actual['direccion']);
            $this->caretaker->addMemento($this->originator->createMemento());
        }

        $this->DEstacion->setId($id);
        $this->DEstacion->setNombre($nombre);
        $this->DEstacion->setDireccion($direccion);
        $this->DEstacion->setUsuarioId($usuario['id']);

        return $this->DEstacion->editar();
    }

    public function restaurarEstadoAnterior(): ?array {
        $memento = $this->caretaker->getMemento();
        if ($memento) {
            $this->originator->setMemento($memento);
            return $this->originator->getState();
        }
        return null;
    }

    public function eliminar(int $id): bool
    {
        $usuario = $this->SesionServicio->obtenerUsuarioActual();
        $this->DEstacion->setId($id);
        $this->DEstacion->setUsuarioId($usuario['id']);
        return $this->DEstacion->eliminar();
    }
}
