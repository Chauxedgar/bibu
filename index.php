<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>

    <!-- CSS del template Mazer (rutas relativas a la carpeta dist/) -->
    <link rel="stylesheet" href="assets/compiled/css/app.css">
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="assets/compiled/css/iconly.css">
    <!-- Bootstrap Icons (incluido en el template) -->
    <link rel="stylesheet" href="assets/extensions/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <!-- Script para inicializar tema (claro/oscuro) -->
    <script src="assets/static/js/initTheme.js"></script>

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

                        <!-- Toggle Claro / Oscuro -->
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <!-- Ícono Sol -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4z" opacity=".3"></path>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox"
                                    id="toggle-dark" style="cursor:pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <!-- Ícono Luna -->
                            <i class="bi bi-moon-fill text-muted" style="font-size:1rem;"></i>
                        </div>

                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Menú lateral -->
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menú</li>

                        <li class="sidebar-item active">
                            <a href="index.php" class="sidebar-link">
                                <i class="bi bi-people-fill"></i>
                                <span>Clientes</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="libros.php" class="sidebar-link">
                                <i class="bi bi-book-fill"></i>
                                <span>Libros</span>
                            </a>
                            <a href="dashboard.php" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ==================== FIN SIDEBAR ==================== -->

        <!-- ==================== CONTENIDO PRINCIPAL ==================== -->
        <div id="main">
            <!-- Barra superior / Navbar -->
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Gestión de Clientes</h3>
                            <p class="text-subtitle text-muted">
                                Administra el listado de clientes y sus libros asociados.
                            </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Alerta de mensajes (éxito o error) -->
                <div id="mensaje" class="d-none"></div>

                <!-- Card principal con la tabla -->
                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <!-- Buscador -->
                            <div class="input-group" style="max-width:350px;">
                                <input type="text" id="buscarInput" class="form-control"
                                    placeholder="Buscar por nombre, email, teléfono...">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="buscarClientes()">
                                    <i class="bi bi-search"></i>
                                </button>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="cargarClientes()">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>

                            <!-- Botón Agregar -->
                            <button class="btn btn-primary" onclick="abrirModalAgregar()">
                                <i class="bi bi-plus-circle me-1"></i> Agregar Cliente
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tablaClientes">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>
                                            <th>Libro Asignado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-body">
                                        <tr>
                                            <td colspan="7" class="text-center">
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

            <!-- ==================== FOOTER ==================== -->
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
         MODAL: Agregar / Editar Cliente
         ==================================================== -->
    <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header" id="modalHeader">
                    <h5 class="modal-title" id="modalTitulo">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form id="formCliente">
                        <!-- ID oculto para edición -->
                        <input type="hidden" id="clienteId" name="clienteId">

                        <div class="row">
                            <!-- ID visible -->
                            <div class="col-md-6 mb-3">
                                <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="id" name="id"
                                    placeholder="Ej: 1001" required>
                                <div class="form-text">Número único que identifica al cliente.</div>
                            </div>

                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nombre completo" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="correo@ejemplo.com" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="Ej: 300 123 4567">
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <textarea class="form-control" id="address" name="address"
                                    rows="2" placeholder="Calle, ciudad..."></textarea>
                            </div>

                            <!-- Libro (llave foránea) -->
                            <div class="col-md-6 mb-3">
                                <label for="idlibros" class="form-label">Libro Asignado</label>
                                <select class="form-select" id="idlibros" name="idlibros">
                                    <option value="">— Sin libro asignado —</option>
                                    <!-- Se carga dinámicamente vía JS -->
                                </select>
                                <div class="form-text">Libro de la tabla <strong>libros</strong> que se le asignará.</div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="guardarCliente()">
                        <i class="bi bi-floppy me-1"></i> Guardar
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- ====================================================
         FIN MODAL
         ==================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts.js"></script>
</body>

</html>
