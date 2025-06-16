<?php
require_once '../../negocio/NUsuarios.php';
require_once '../../negocio/SesionServicio.php';

$NUsuarios = new NUsuarios();
$sesionServicio = new SesionServicio();
$sesionServicio->redirigirSiAutenticado('../panel.php');


$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $clave = $_POST['clave'];
    
    $resultado = $NUsuarios->autenticarUsuario($correo, $clave);
    
    if ($resultado['exito']) {
        $sesionServicio->iniciarSesion($resultado['usuario']);
        header('Location: ../panel.php');
        exit;
    } else {
        $mensaje = $resultado['mensaje'];
        $tipoMensaje = 'error';
    }
}

include '../includes/header.php';
?>

<?php if (!empty($mensaje)): ?>
    <div class="alerta alerta-<?php echo $tipoMensaje; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

<div class="formulario">
    <h2>Iniciar Sesión</h2>
    
    <form action="login.php" method="post">
        <div class="grupo-formulario">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        
        <div class="grupo-formulario">
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required>
        </div>
        
        <div class="grupo-formulario">
            <button type="submit" class="boton">Iniciar Sesión</button>
        </div>
    </form>
    
    <p>¿No tiene una cuenta? <a href="registro.php">Regístrese aquí</a></p>
</div>

<?php include '../includes/footer.php'; ?>
