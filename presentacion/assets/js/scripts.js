// presentacion/assets/js/scripts.js
document.addEventListener('DOMContentLoaded', function() {
    // Formulario de registro
    const formRegistro = document.getElementById('formRegistro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            const clave = document.getElementById('clave').value;
            const confirmarClave = document.getElementById('confirmarClave').value;
            
            if (clave !== confirmarClave) {
                e.preventDefault();
                mostrarMensaje('Las contraseñas no coinciden', 'error');
            }
        });
    }
    
    // Función para mostrar mensajes
    function mostrarMensaje(mensaje, tipo) {
        const contenedor = document.querySelector('.mensajes');
        if (contenedor) {
            const div = document.createElement('div');
            div.className = `alerta alerta-${tipo}`;
            div.textContent = mensaje;
            
            contenedor.innerHTML = '';
            contenedor.appendChild(div);
            
            setTimeout(() => {
                div.remove();
            }, 5000);
        }
    }
});