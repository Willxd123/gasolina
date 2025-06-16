<?php

class EstacionMemento {
    private string $nombre;
    private string $direccion;

    public function __construct(string $nombre, string $direccion) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }
}
