<?php

class SesionServicio {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function iniciarSesion($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_correo'] = $usuario['correo'];
    }
    
    public function cerrarSesion() {
        // Eliminar todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        session_destroy();
    }
    
    public function estaAutenticado() {
        return isset($_SESSION['usuario_id']);
    }
    
    public function obtenerUsuarioActual() {
        if ($this->estaAutenticado()) {
            return array(
                'id' => $_SESSION['usuario_id'],
                'nombre' => $_SESSION['usuario_nombre'],
                'correo' => $_SESSION['usuario_correo']
            );
        }
        return null;
    }
    
    public function redirigirSiNoAutenticado($url) {
        if (!$this->estaAutenticado()) {
            header("Location: $url");
            exit;
        }
    }
    
    public function redirigirSiAutenticado($url) {
        if ($this->estaAutenticado()) {
            header("Location: $url");
            exit;
        }
    }
}