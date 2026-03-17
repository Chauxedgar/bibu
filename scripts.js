// ============================================================
//  scripts.js  —  CRUD Clientes
// ============================================================

document.addEventListener('DOMContentLoaded', function () {
    cargarClientes();
    cargarLibros();
});

// ------------------------------------------------------------
// UTILIDADES
// ------------------------------------------------------------

function mostrarMensaje(texto, tipo) {
    const div = document.getElementById('mensaje');
    div.className = `alert alert-${tipo} alert-dismissible fade show`;
    div.innerHTML = `${texto}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    div.classList.remove('d-none');
    setTimeout(() => { div.classList.add('d-none'); }, 4000);
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function abrirModal() {
    new bootstrap.Modal(document.getElementById('modalCliente')).show();
}

function cerrarModal() {
    const el = document.getElementById('modalCliente');
    const m = bootstrap.Modal.getInstance(el);
    if (m) m.hide();
}

// ------------------------------------------------------------
// LIBROS — llenar el <select>
// ------------------------------------------------------------

function cargarLibros() {
    return fetch('api.php?tabla=libros')
        .then(res => res.json())
        .then(libros => {
            const select = document.getElementById('idlibros');
            select.innerHTML = '<option value="">— Sin libro asignado —</option>';
            libros.forEach(libro => {
                const opt = document.createElement('option');
                opt.value = libro.idlibros;
                opt.textContent = `[${libro.idlibros}] ${escapeHtml(libro.titulo)} — ${escapeHtml(libro.autor)}`;
                select.appendChild(opt);
            });
            return libros;
        })
        .catch(() => console.warn('No se pudieron cargar los libros.'));
}

// ------------------------------------------------------------
// CLIENTES — Leer
// ------------------------------------------------------------

function cargarClientes() {
    fetch('api.php')
        .then(res => res.json())
        .then(data => renderizarTabla(data))
        .catch(() => mostrarMensaje('Error al cargar clientes.', 'danger'));
}

function buscarClientes() {
    const termino = document.getElementById('buscarInput').value.trim().toLowerCase();
    if (!termino) { cargarClientes(); return; }

    fetch('api.php')
        .then(res => res.json())
        .then(clientes => {
            const filtrados = clientes.filter(c =>
                (c.name && c.name.toLowerCase().includes(termino)) ||
                (c.email && c.email.toLowerCase().includes(termino)) ||
                (c.phone_number && c.phone_number.includes(termino)) ||
                (c.address && c.address.toLowerCase().includes(termino))
            );
            renderizarTabla(filtrados);
        })
        .catch(() => mostrarMensaje('Error al buscar.', 'danger'));
}

function renderizarTabla(clientes) {
    const tbody = document.getElementById('tabla-body');
    tbody.innerHTML = '';

    if (!clientes.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                    No hay clientes registrados.
                </td>
            </tr>`;
        return;
    }

    clientes.forEach(c => {
        const libroTexto = c.titulo
            ? `<span class="badge bg-secondary">${escapeHtml(c.titulo)}</span>`
            : '<span class="text-muted">—</span>';

        tbody.innerHTML += `
            <tr>
                <td><strong>${escapeHtml(String(c.id))}</strong></td>
                <td>${escapeHtml(c.name)}</td>
                <td>${escapeHtml(c.email)}</td>
                <td>${escapeHtml(c.phone_number || '')}</td>
                <td>${escapeHtml(c.address || '')}</td>
                <td>${libroTexto}</td>
                <td>
                    <button class="btn btn-sm btn-warning me-1"
                        onclick="editarCliente(${c.id})">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-danger"
                        onclick="eliminarCliente(${c.id})">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            </tr>`;
    });
}

// ------------------------------------------------------------
// MODAL — Agregar
// ------------------------------------------------------------

function abrirModalAgregar() {
    document.getElementById('modalTitulo').textContent = '➕ Agregar Cliente';
    document.getElementById('modalHeader').className = 'modal-header bg-success text-white';
    document.getElementById('formCliente').reset();
    document.getElementById('clienteId').value = '';
    document.getElementById('id').disabled = false;

    cargarLibros().then(() => {
        abrirModal();
    });
}

// ------------------------------------------------------------
// MODAL — Editar
// ------------------------------------------------------------

function editarCliente(id) {
    fetch(`api.php?id=${id}`)
        .then(res => res.json())
        .then(cliente => {
            document.getElementById('modalTitulo').textContent = '✏️ Editar Cliente';
            document.getElementById('modalHeader').className = 'modal-header bg-warning text-dark';
            document.getElementById('clienteId').value = cliente.id;
            document.getElementById('id').value = cliente.id;
            document.getElementById('id').disabled = true;
            document.getElementById('name').value = cliente.name;
            document.getElementById('email').value = cliente.email;
            document.getElementById('phone').value = cliente.phone_number || '';
            document.getElementById('address').value = cliente.address || '';

            cargarLibros().then(() => {
                document.getElementById('idlibros').value = cliente.idlibros || '';
                abrirModal();
            });
        })
        .catch(() => mostrarMensaje('Error al cargar el cliente.', 'danger'));
}

// ------------------------------------------------------------
// GUARDAR
// ------------------------------------------------------------

function guardarCliente() {
    const idOculto  = document.getElementById('clienteId').value;
    const idCampo   = document.getElementById('id').value;
    const nombre    = document.getElementById('name').value.trim();
    const email     = document.getElementById('email').value.trim();
    const telefono  = document.getElementById('phone').value.trim();
    const direccion = document.getElementById('address').value.trim();
    const idlibros  = document.getElementById('idlibros').value;

    if (!idCampo || !nombre || !email) {
        mostrarMensaje('Completa los campos obligatorios (ID, Nombre, Email).', 'warning');
        return;
    }

    const esEdicion = idOculto !== '';

    if (!esEdicion) {
        fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: idCampo, name: nombre, email: email,
                phone: telefono, address: direccion,
                idlibros: idlibros || null
            })
        })
        .then(res => res.json())
        .then(data => manejarRespuesta(data))
        .catch(() => mostrarMensaje('Error de conexión.', 'danger'));

    } else {
        const formData = new URLSearchParams({
            id: idOculto, name: nombre, email: email,
            phone: telefono, address: direccion,
            idlibros: idlibros || ''
        });

        fetch(`api.php?id=${idOculto}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        })
        .then(res => res.json())
        .then(data => manejarRespuesta(data))
        .catch(() => mostrarMensaje('Error de conexión.', 'danger'));
    }
}

function manejarRespuesta(data) {
    if (data.success) {
        mostrarMensaje(data.success, 'success');
        cerrarModal();
        cargarClientes();
    } else {
        mostrarMensaje(data.error || 'Error al guardar.', 'danger');
    }
}

// ------------------------------------------------------------
// ELIMINAR
// ------------------------------------------------------------

function eliminarCliente(id) {
    if (!confirm('¿Estás seguro de eliminar este cliente?')) return;

    fetch(`api.php?id=${id}`, { method: 'DELETE' })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                mostrarMensaje(data.success, 'success');
                cargarClientes();
            } else {
                mostrarMensaje(data.error || 'Error al eliminar.', 'danger');
            }
        })
        .catch(() => mostrarMensaje('Error de conexión.', 'danger'));
}
