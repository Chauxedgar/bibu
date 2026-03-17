// Cargar clientes al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    cargarClientes();
});

// Mostrar mensajes de éxito o error
function mostrarMensaje(texto, tipo) {
    const mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.textContent = texto;
    mensajeDiv.className = 'mensaje mensaje-' + tipo;

    setTimeout(() => {
        mensajeDiv.style.display = 'none';
    }, 3000);
}

// Cargar todos los clientes en la tabla
function cargarClientes() {
    fetch('api.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tabla-body');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No hay clientes registrados</td></tr>';
                return;
            }

            data.forEach(cliente => {
                const fila = `
                    <tr>
                        <td><strong>${cliente.id}</strong></td>
                        <td>${escapeHtml(cliente.name)}</td>
                        <td>${escapeHtml(cliente.email)}</td>
                        <td>${escapeHtml(cliente.phone_number || '')}</td>
                        <td>${escapeHtml(cliente.address || '')}</td>
                        <td>
                            <button onclick="editarCliente(${cliente.id})" class="btn btn-editar">✏️ Editar</button>
                            <button onclick="eliminarCliente(${cliente.id})" class="btn btn-eliminar">🗑️ Eliminar</button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += fila;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar clientes', 'error');
        });
}

// Buscar clientes por nombre, email, teléfono o dirección
function buscarClientes() {
    const busqueda = document.getElementById('buscarInput').value;

    if (!busqueda) {
        cargarClientes();
        return;
    }

    fetch('api.php')
        .then(response => response.json())
        .then(clientes => {
            const filtrados = clientes.filter(cliente =>
                cliente.name.toLowerCase().includes(busqueda.toLowerCase()) ||
                (cliente.email && cliente.email.toLowerCase().includes(busqueda.toLowerCase())) ||
                (cliente.phone_number && cliente.phone_number.includes(busqueda)) ||
                (cliente.address && cliente.address.toLowerCase().includes(busqueda.toLowerCase()))
            );

            const tbody = document.getElementById('tabla-body');
            tbody.innerHTML = '';

            if (filtrados.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No se encontraron resultados</td></tr>';
                return;
            }

            filtrados.forEach(cliente => {
                const fila = `
                    <tr>
                        <td><strong>${cliente.id}</strong></td>
                        <td>${escapeHtml(cliente.name)}</td>
                        <td>${escapeHtml(cliente.email)}</td>
                        <td>${escapeHtml(cliente.phone_number || '')}</td>
                        <td>${escapeHtml(cliente.address || '')}</td>
                        <td>
                            <button onclick="editarCliente(${cliente.id})" class="btn btn-editar">✏️ Editar</button>
                            <button onclick="eliminarCliente(${cliente.id})" class="btn btn-eliminar">🗑️ Eliminar</button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += fila;
            });
        });
}

// Abrir modal para agregar un nuevo cliente
function abrirModalAgregar() {
    document.getElementById('modalTitulo').textContent = '➕ Agregar Cliente';
    document.getElementById('modalHeader').style.background = '#28a745';
    document.getElementById('formCliente').reset();
    document.getElementById('clienteId').value = '';
    document.getElementById('modalCliente').style.display = 'block';
}

// Cargar datos de un cliente en el modal para editar
function editarCliente(id) {
    fetch(`api.php?id=${id}`)
        .then(response => response.json())
        .then(cliente => {
            document.getElementById('modalTitulo').textContent = '✏️ Editar Cliente';
            document.getElementById('modalHeader').style.background = '#ffc107';
            document.getElementById('clienteId').value = cliente.id;
            document.getElementById('id').value = cliente.id;
            document.getElementById('name').value = cliente.name;
            document.getElementById('email').value = cliente.email;
            document.getElementById('phone').value = cliente.phone_number || '';
            document.getElementById('address').value = cliente.address || '';
            document.getElementById('modalCliente').style.display = 'block';
        });
}

// Guardar cliente (crear o actualizar según corresponda)
function guardarCliente() {
    const id = document.getElementById('clienteId').value;
    const idField = document.getElementById('id').value;
    const nombre = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('phone').value;
    const direccion = document.getElementById('address').value;

    const datos = {
        id: idField,
        name: nombre,
        email: email,
        phone: telefono,
        address: direccion
    };

    let url = 'api.php';
    let metodo = 'POST';

    if (id) {
        url = `api.php?id=${id}`;
        metodo = 'PUT';
    }

    if (metodo === 'PUT') {
        const formData = new URLSearchParams();
        formData.append('id', idField);
        formData.append('name', nombre);
        formData.append('email', email);
        formData.append('phone', telefono);
        formData.append('address', direccion);

        fetch(url, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje(data.success, 'exito');
                    cerrarModal();
                    cargarClientes();
                } else {
                    mostrarMensaje(data.error || 'Error al guardar', 'error');
                }
            })
            .catch(() => mostrarMensaje('Error de conexión', 'error'));

    } else {
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje(data.success, 'exito');
                    cerrarModal();
                    cargarClientes();
                } else {
                    mostrarMensaje(data.error || 'Error al guardar', 'error');
                }
            })
            .catch(() => mostrarMensaje('Error de conexión', 'error'));
    }
}

// Eliminar un cliente por ID
function eliminarCliente(id) {
    if (!confirm('¿Estás seguro de eliminar este cliente?')) return;

    fetch(`api.php?id=${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarMensaje(data.success, 'exito');
                cargarClientes();
            } else {
                mostrarMensaje(data.error || 'Error al eliminar', 'error');
            }
        })
        .catch(() => mostrarMensaje('Error de conexión', 'error'));
}

// Cerrar el modal
function cerrarModal() {
    document.getElementById('modalCliente').style.display = 'none';
}

// Escapar caracteres HTML para evitar XSS
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function (event) {
    const modal = document.getElementById('modalCliente');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};
