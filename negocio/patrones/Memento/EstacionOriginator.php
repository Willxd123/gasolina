<?php

class EstacionOriginator {
    private string $nombre;
    private string $direccion;

    public function setState(string $nombre, string $direccion): void {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
    }

    public function createMemento(): EstacionMemento {
        return new EstacionMemento($this->nombre, $this->direccion);
    }

    public function setMemento(EstacionMemento $memento): void {
        $this->nombre = $memento->getNombre();
        $this->direccion = $memento->getDireccion();
    }

    public function getState(): array {
        return [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion
        ];
    }
}
