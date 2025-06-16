<?php
require_once '../../negocio/NUsuarios.php';
require_once '../../negocio/SesionServicio.php';

$NUsuarios = new NUsuarios();
$sesionServicio = new SesionServicio();
$sesionServicio->redirigirSiAutenticado('../panel.php');


$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $clave = $_POST['clave'];
    $confirmarClave = $_POST['confirmarClave'];
    
    $resultado = $NUsuarios->registrarUsuario($nombre, $correo, $clave, $confirmarClave);
    
    $mensaje = $resultado['mensaje'];
    $tipoMensaje = $resultado['exito'] ? 'exito' : 'error';
}

include '../includes/header.php';
?>

<?php if (!empty($mensaje)): ?>
    <div class="alerta alerta-<?php echo $tipoMensaje; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

<div class="formulario">
    <h2>Registro de Usuario</h2>
    
    <form action="registro.php" method="post" id="formRegistro">
        <div class="grupo-formulario">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div class="grupo-formulario">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        
        <div class="grupo-formulario">
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required minlength="6">
        </div>
        
        <div class="grupo-formulario">
            <label for="confirmarClave">Confirmar contraseña:</label>
            <input type="password" id="confirmarClave" name="confirmarClave" required minlength="6">
        </div>
        
        <div class="grupo-formulario">
            <button type="submit" class="boton">Registrarse</button>
        </div>
    </form>
    
    <p>¿Ya tiene una cuenta? <a href="login.php">Inicie sesión aquí</a></p>
</div>

<?php include '../includes/footer.php'; ?>
