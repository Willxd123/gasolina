<?php
require_once __DIR__ . '/../datos/DUsuarios.php';
require_once __DIR__ . '/../datos/migraciones/Migrador.php';
Migrador::ejecutar(); // Ejecuta las migraciones automáticamente

class NUsuarios {
    private $DUsuarios;

    public function __construct() {
        $this->DUsuarios = new DUsuarios();
    }

    public function registrarUsuario($nombre, $correo, $clave, $confirmarClave) {
        // Validaciones de campos
        if (empty($nombre) || empty($correo) || empty($clave) || empty($confirmarClave)) {
            return array('exito' => false, 'mensaje' => 'Todos los campos son obligatorios');
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return array('exito' => false, 'mensaje' => 'El correo electrónico no es válido');
        }

        if ($clave !== $confirmarClave) {
            return array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden');
        }

        if (strlen($clave) < 6) {
            return array('exito' => false, 'mensaje' => 'La contraseña debe tener al menos 6 caracteres');
        }

        // Verificar si el correo ya está registrado
        if ($this->DUsuarios->existeCorreo($correo)) {
            return array('exito' => false, 'mensaje' => 'El correo ya está registrado');
        }

        // Asignar datos al modelo
        $this->DUsuarios->setNombre($nombre);
        $this->DUsuarios->setCorreo($correo);
        $this->DUsuarios->setClave($clave); 

        // Registrar en base de datos
        $resultado = $this->DUsuarios->registrarUsuario();

        if ($resultado) {
            return array('exito' => true, 'mensaje' => 'Usuario registrado correctamente');
        } else {
            return array('exito' => false, 'mensaje' => 'Error al registrar el usuario');
        }
    }

    public function autenticarUsuario($correo, $clave) {
        // Validación de entrada
        if (empty($correo) || empty($clave)) {
            return array('exito' => false, 'mensaje' => 'Todos los campos son obligatorios');
        }

        // Obtener usuario por correo
        $usuario = $this->DUsuarios->obtenerUsuarioPorCorreo($correo);

        if (!$usuario) {
            return array('exito' => false, 'mensaje' => 'Usuario o contraseña incorrectos');
        }

        // Verificar contraseña
        if (password_verify($clave, $usuario['clave'])) {
            return array('exito' => true, 'mensaje' => 'Inicio de sesión exitoso', 'usuario' => $usuario);
        } else {
            return array('exito' => false, 'mensaje' => 'Usuario o contraseña incorrectos');
        }
    }
}
