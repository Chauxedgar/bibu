<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
                            <a href="dashboard.php">
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

                        <li class="sidebar-item active">
                            <a href="dashboard.php" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
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
                            <h3>Dashboard</h3>
                            <p class="text-subtitle text-muted">Resumen general del sistema.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- ===== TARJETAS DE ESTADÍSTICAS ===== -->
                <div class="row g-3 mb-4" id="tarjetas">
                    <!-- Se renderizan desde JS -->
                </div>

                <!-- ===== FILA: Gráfica + Libro popular ===== -->
                <div class="row g-3 mb-4">
                    <!-- Gráfica clientes con/sin libro -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-pie-chart-fill me-2 text-primary"></i>
                                    Clientes con / sin libro asignado
                                </h5>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <canvas id="graficaLibros" style="max-height:260px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Libro más popular -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-trophy-fill me-2 text-warning"></i>
                                    Libros por popularidad
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="listaPopularidad"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== TABLA ÚLTIMOS CLIENTES ===== -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history me-2 text-success"></i>
                            Últimos 5 clientes registrados
                        </h5>
                        <a href="index.php" class="btn btn-sm btn-outline-primary">
                            Ver todos <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Libro asignado</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaUltimos"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!-- /page-heading -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
    // ============================================================
    //  Dashboard — estadísticas
    // ============================================================

    function escapeHtml(t) {
        if (!t) return '';
        const d = document.createElement('div');
        d.textContent = t;
        return d.innerHTML;
    }

    async function cargarDashboard() {
        try {
            const [clientes, libros] = await Promise.all([
                fetch('api.php').then(r => r.json()),
                fetch('api.php?tabla=libros').then(r => r.json())
            ]);

            const totalClientes   = clientes.length;
            const totalLibros     = libros.length;
            const conLibro        = clientes.filter(c => c.idlibros).length;
            const sinLibro        = totalClientes - conLibro;

            renderizarTarjetas(totalClientes, totalLibros, conLibro, sinLibro);
            renderizarGrafica(conLibro, sinLibro);
            renderizarPopularidad(clientes, libros);
            renderizarUltimos(clientes);

        } catch (e) {
            console.error('Error cargando dashboard:', e);
        }
    }

    // -- Tarjetas --

    function renderizarTarjetas(totalClientes, totalLibros, conLibro, sinLibro) {
        const tarjetas = [
            {
                titulo: 'Total Clientes',
                valor: totalClientes,
                icono: 'bi-people-fill',
                color: 'primary'
            },
            {
                titulo: 'Total Libros',
                valor: totalLibros,
                icono: 'bi-book-fill',
                color: 'success'
            },
            {
                titulo: 'Clientes con Libro',
                valor: conLibro,
                icono: 'bi-person-check-fill',
                color: 'info'
            },
            {
                titulo: 'Clientes sin Libro',
                valor: sinLibro,
                icono: 'bi-person-x-fill',
                color: 'warning'
            }
        ];

        document.getElementById('tarjetas').innerHTML = tarjetas.map(t => `
            <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-light-${t.color} me-3">
                                <i class="bi ${t.icono} fs-3 text-${t.color}"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">${t.titulo}</h6>
                                <h3 class="mb-0 fw-bold">${t.valor}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // -- Gráfica --

    function renderizarGrafica(conLibro, sinLibro) {
        const ctx = document.getElementById('graficaLibros').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Con libro', 'Sin libro'],
                datasets: [{
                    data: [conLibro, sinLibro],
                    backgroundColor: ['#435ebe', '#f9c851'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // -- Popularidad --

    function renderizarPopularidad(clientes, libros) {
        // Contar cuántos clientes tiene cada libro
        const conteo = {};
        clientes.forEach(c => {
            if (c.idlibros) {
                conteo[c.idlibros] = (conteo[c.idlibros] || 0) + 1;
            }
        });

        // Ordenar libros por cantidad de clientes descendente
        const ordenados = libros
            .map(l => ({ ...l, total: conteo[l.idlibros] || 0 }))
            .sort((a, b) => b.total - a.total);

        const max = ordenados[0]?.total || 1;

        document.getElementById('listaPopularidad').innerHTML = ordenados.map((l, i) => `
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span>
                        ${i === 0 && l.total > 0 ? '<i class="bi bi-trophy-fill text-warning me-1"></i>' : ''}
                        ${escapeHtml(l.titulo)}
                    </span>
                    <span class="fw-bold">${l.total} cliente${l.total !== 1 ? 's' : ''}</span>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-primary" style="width:${max > 0 ? (l.total / max * 100) : 0}%"></div>
                </div>
            </div>
        `).join('') || '<p class="text-muted">No hay datos.</p>';
    }

    // -- Últimos clientes --

    function renderizarUltimos(clientes) {
        const ultimos = clientes.slice(-5).reverse();
        const tbody = document.getElementById('tablaUltimos');

        if (!ultimos.length) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No hay clientes.</td></tr>`;
            return;
        }

        tbody.innerHTML = ultimos.map(c => `
            <tr>
                <td><strong>${escapeHtml(String(c.id))}</strong></td>
                <td>${escapeHtml(c.name)}</td>
                <td>${escapeHtml(c.email)}</td>
                <td>${escapeHtml(c.phone_number || '—')}</td>
                <td>
                    ${c.titulo
                        ? `<span class="badge bg-secondary">${escapeHtml(c.titulo)}</span>`
                        : '<span class="text-muted">—</span>'}
                </td>
            </tr>
        `).join('');
    }

    // Iniciar
    cargarDashboard();
    </script>
</body>
</html>
