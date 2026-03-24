<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros</title>

    <link rel="stylesheet" href="assets/compiled/css/app.css">
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="assets/extensions/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    

    <div id="app">
        <!-- ==================== SIDEBAR ==================== -->
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets/compiled/svg/logo.svg" alt="Logo">
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <i class="bi bi-sun-fill text-muted" style="font-size:1rem;"></i>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox"
                                    id="toggle-dark" style="cursor:pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <i class="bi bi-moon-fill text-muted" style="font-size:1rem;"></i>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menú</li>

                        <li class="sidebar-item">
                            <a href="index.php" class="sidebar-link">
                                <i class="bi bi-people-fill"></i>
                                <span>Clientes</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
                            <a href="libros.php" class="sidebar-link">
                                <i class="bi bi-book-fill"></i>
                                <span>Libros</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ==================== FIN SIDEBAR ==================== -->

        <!-- ==================== CONTENIDO PRINCIPAL ==================== -->
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Gestión de Libros</h3>
                            <p class="text-subtitle text-muted">
                                Administra el catálogo de libros disponibles.
                            </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Libros</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Zona de mensajes -->
                <div id="mensaje" class="d-none"></div>

                <!-- Card con la tabla -->
                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <!-- Buscador -->
                            <div class="input-group" style="max-width:350px;">
                                <input type="text" id="buscarInput" class="form-control"
                                    placeholder="Buscar por título o autor...">
                                <button class="btn btn-outline-secondary" onclick="buscarLibros()">
                                    <i class="bi bi-search"></i>
                                </button>
                                <button class="btn btn-outline-secondary" onclick="cargarLibros()">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>

                            <!-- Botón Agregar -->
                            <button class="btn btn-primary" onclick="abrirModalAgregar()">
                                <i class="bi bi-plus-circle me-1"></i> Agregar Libro
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Autor</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-body">
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; CRUD Clientes</p>
                    </div>
                </div>
            </footer>
        </div>
        <!-- ==================== FIN CONTENIDO PRINCIPAL ==================== -->
    </div>

    <!-- ====================================================
         MODAL: Agregar / Editar Libro
         ==================================================== -->
    <div class="modal fade" id="modalLibro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" id="modalHeader">
                    <h5 class="modal-title" id="modalTitulo">Agregar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formLibro">
                        <input type="hidden" id="libroId">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">
                                Título <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="titulo"
                                placeholder="Ej: Cien Años de Soledad" required>
                        </div>

                        <div class="mb-3">
                            <label for="autor" class="form-label">
                                Autor <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="autor"
                                placeholder="Ej: Gabriel García Márquez" required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button class="btn btn-primary" onclick="guardarLibro()">
                        <i class="bi bi-floppy me-1"></i> Guardar
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- ====================================================
         FIN MODAL
         ==================================================== -->

    
    <script>
    // ============================================================
    //  CRUD Libros — JavaScript inline
    // ============================================================

    document.addEventListener('DOMContentLoaded', cargarLibros);

    // -- Utilidades --

    function mostrarMensaje(texto, tipo) {
        const div = document.getElementById('mensaje');
        div.className = `alert alert-${tipo} alert-dismissible fade show`;
        div.innerHTML = `${texto}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        div.classList.remove('d-none');
        setTimeout(() => { div.classList.add('d-none'); }, 4000);
    }

    function escapeHtml(t) {
        if (!t) return '';
        const d = document.createElement('div');
        d.textContent = t;
        return d.innerHTML;
    }

    // -- Leer --

    function cargarLibros() {
        fetch('api.php?tabla=libros')
            .then(r => r.json())
            .then(data => renderizarTabla(data))
            .catch(() => mostrarMensaje('Error al cargar libros.', 'danger'));
    }

    function buscarLibros() {
        const termino = document.getElementById('buscarInput').value.trim().toLowerCase();
        if (!termino) { cargarLibros(); return; }

        fetch('api.php?tabla=libros')
            .then(r => r.json())
            .then(libros => {
                const filtrados = libros.filter(l =>
                    l.titulo.toLowerCase().includes(termino) ||
                    l.autor.toLowerCase().includes(termino)
                );
                renderizarTabla(filtrados);
            });
    }

    function renderizarTabla(libros) {
        const tbody = document.getElementById('tabla-body');
        tbody.innerHTML = '';

        if (!libros.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                        No hay libros registrados.
                    </td>
                </tr>`;
            return;
        }

        libros.forEach(l => {
            tbody.innerHTML += `
                <tr>
                    <td><strong>${escapeHtml(String(l.idlibros))}</strong></td>
                    <td>${escapeHtml(l.titulo)}</td>
                    <td>${escapeHtml(l.autor)}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1"
                            onclick="editarLibro(${l.idlibros})" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger"
                            onclick="eliminarLibro(${l.idlibros})" title="Eliminar">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>`;
        });
    }

    // -- Modal Agregar --

    function abrirModalAgregar() {
        document.getElementById('modalTitulo').textContent = '➕ Agregar Libro';
        document.getElementById('modalHeader').className = 'modal-header bg-success text-white';
        document.getElementById('formLibro').reset();
        document.getElementById('libroId').value = '';
        new bootstrap.Modal(document.getElementById('modalLibro')).show();
    }

    // -- Modal Editar --

    function editarLibro(id) {
        fetch(`api.php?tabla=libros&id=${id}`)
            .then(r => r.json())
            .then(libro => {
                document.getElementById('modalTitulo').textContent = '✏️ Editar Libro';
                document.getElementById('modalHeader').className = 'modal-header bg-warning text-dark';
                document.getElementById('libroId').value = libro.idlibros;
                document.getElementById('titulo').value  = libro.titulo;
                document.getElementById('autor').value   = libro.autor;
                new bootstrap.Modal(document.getElementById('modalLibro')).show();
            })
            .catch(() => mostrarMensaje('Error al cargar el libro.', 'danger'));
    }

    // -- Guardar --

    function guardarLibro() {
        const id     = document.getElementById('libroId').value;
        const titulo = document.getElementById('titulo').value.trim();
        const autor  = document.getElementById('autor').value.trim();

        if (!titulo || !autor) {
            mostrarMensaje('Título y autor son obligatorios.', 'warning');
            return;
        }

        const esEdicion = id !== '';
        const url    = esEdicion ? `api.php?tabla=libros&id=${id}` : 'api.php?tabla=libros';
        const method = esEdicion ? 'PUT' : 'POST';

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ titulo, autor })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                mostrarMensaje(data.success, 'success');
                bootstrap.Modal.getInstance(document.getElementById('modalLibro')).hide();
                cargarLibros();
            } else {
                mostrarMensaje(data.error || 'Error al guardar.', 'danger');
            }
        })
        .catch(() => mostrarMensaje('Error de conexión.', 'danger'));
    }

    // -- Eliminar --

    function eliminarLibro(id) {
        if (!confirm('¿Eliminar este libro? Los clientes que lo tengan asignado quedarán sin libro.')) return;

        fetch(`api.php?tabla=libros&id=${id}`, { method: 'DELETE' })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje(data.success, 'success');
                    cargarLibros();
                } else {
                    mostrarMensaje(data.error || 'Error al eliminar.', 'danger');
                }
            })
        .catch(() => mostrarMensaje('Error de conexión.', 'danger'));
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
