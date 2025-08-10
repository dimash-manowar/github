<?php
// Views/Usuarios/index.php
$u = $_SESSION['user'] ?? [];
$nombre = $u['nombre'] ?? $u['name'] ?? 'Usuario';
$foto = !empty($u['foto'])
    ? BASE_URL . 'Assets/imagen/users/' . $u['foto']
    : BASE_URL . 'Assets/imagen/usuario.png';
?>

<?php include 'Views/Usuarios/topbar.php'; ?>
<div class="d-flex" id="wrapper">
    <?php include 'Views/Usuarios/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <!-- Saludo + Progreso -->
        <div class="bg-dark border rounded-3 p-3 mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= htmlspecialchars($foto) ?>" alt="avatar" width="56" height="56" class="rounded-circle border">
                    <div>
                        <h1 class="h5 mb-1">Hola, <?= htmlspecialchars($nombre) ?> ✨</h1>
                        <div class="text-secondary">Bienvenido a tu panel de Orion3D</div>
                    </div>
                </div>
                <div class="text-end">
                    <div class="text-secondary small mb-1">Progreso global</div>
                    <div style="width:96px;height:96px">
                        <canvas id="ringProgreso" width="96" height="96"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPIs -->
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <div class="text-secondary small">Cursos</div>
                    <div class="fs-4 fw-semibold" id="kpi-cursos">0</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <div class="text-secondary small">Progreso</div>
                    <div class="fs-4 fw-semibold"><span id="kpi-progreso">0</span>%</div>
                    <div class="progress mt-2" style="height:6px;">
                        <div id="kpi-progreso-bar" class="progress-bar" style="width:0%"></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <div class="text-secondary small">Horas</div>
                    <div class="fs-4 fw-semibold" id="kpi-horas">0</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <div class="text-secondary small">Logros</div>
                    <div class="fs-4 fw-semibold" id="kpi-logros">0</div>
                </div>
            </div>
        </div>

        <!-- Actividad + Placeholder próximos pasos -->
        <div class="row g-3 mt-1">
            <div class="col-lg-8">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="h6 m-0">Actividad semanal (horas)</h2>
                        <span class="badge bg-secondary">Últimos 7 días</span>
                    </div>
                    <canvas id="chartActividad" height="120" class="mt-3"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-dark border rounded-3 p-3 h-100">
                    <h2 class="h6">Sugerencias</h2>
                    <ul class="small text-secondary m-0">
                        <li>Retoma tu curso más avanzado.</li>
                        <li>Completa 1 lección hoy para mantener racha.</li>
                        <li>Revisa tus logros recientes.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tus cursos (tabla) -->
        <div class="bg-dark border rounded-3 p-3 mt-3">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="h6 m-0">Tus cursos</h2>
                <a href="<?= BASE_URL ?>programacionWeb/html_css" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-plus-lg me-1"></i>Explorar cursos
                </a>
            </div>
            <div class="table-responsive mt-2">
                <table id="tablaCursos" class="table table-dark table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Progreso</th>
                            <th>Lecciones</th>
                            <th>Último acceso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cursos)): foreach ($cursos as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['titulo']) ?></td>
                                    <td><?= (int)$c['progreso'] ?>%</td>
                                    <td><?= (int)$c['lecciones_comp'] ?>/<?= (int)$c['lecciones_tot'] ?></td>
                                    <td><?= htmlspecialchars($c['ultimo_acceso']) ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-light" href="<?= BASE_URL ?>cursos/ver/<?= (int)$c['id'] ?>">
                                            <i class="bi bi-play-fill me-1"></i>Continuar
                                        </a>
                                        <button class="btn btn-sm btn-outline-warning btn-fav"
                                            data-type="curso" data-id="<?= (int)$c['id'] ?>"
                                            aria-pressed="<?= !empty($c['favorito']) ? 'true' : 'false' ?>">
                                            <i class="bi <?= !empty($c['favorito']) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>