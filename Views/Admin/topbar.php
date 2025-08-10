<?php include 'Views/Admin/headerAdmin.php'; ?>
<!-- Header / Topbar -->
<nav id="admin-topbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNoti" aria-labelledby="offcanvasNotiLabel" style="width: 380px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNotiLabel">Notificaciones (Q&A pendientes)</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <div id="noti-list" class="list-group list-group-flush small">
                <div class="text-secondary">Cargando…</div>
            </div>
        </div>
    </div>

    <!-- Botón de hamburguesa para mostrar el sidebar -->
    <button class="btn btn-outline-light me-3 d-lg-none" id="toggleSidebar">
        <i class="bi bi-list"></i>
    </button>


    <!-- Logo + nombre web -->
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>admin">
        <img src="<?= BASE_URL ?>Assets/imagen/Logo.png" height="30" class="me-2" alt="Orion3D">
        Orion3D Admin
    </a>

    <!-- Iconos a la derecha -->
    <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item me-3">
            <button class="nav-link btn btn-link position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNoti" aria-controls="offcanvasNoti">
                <i class="bi bi-bell fs-5"></i>
                <span id="noti-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none">0</span>
            </button>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= BASE_URL ?>Assets/imagen/frontal.jpg" class="rounded-circle me-2" width="32" height="32" alt="Usuario">
                Juan Pérez
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/perfil">Perfil</a></li>
                <li><a class="dropdown-item" href="#">Configuración</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="#">Cerrar Sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>
<?php include 'Views/Admin/footerAdmin.php'; ?>