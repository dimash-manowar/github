<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>Usuario">
        <img src="<?= BASE_URL ?>Assets/imagen/Logo.png" height="30" class="me-2">
        Usuario - Orion3D
    </a>

    <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-5"></i>
                <span id="notif-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none">0</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark p-0" aria-labelledby="notifDropdown" style="min-width: 320px;">
                <li class="p-2 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Notificaciones</span>
                    <button class="btn btn-sm btn-outline-light" id="notif-markall">Marcar todas</button>
                </li>
                <li id="notif-list">
                    <div class="p-3 text-secondary">Sin notificaciones.</div>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                <img src="<?= BASE_URL ?>Assets/imagen/users/<?= $_SESSION['user']['foto'] ?>" class="rounded-circle me-2" width="32" height="32">
                <?= $_SESSION['user']['nombre_usuario'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>Usuario/perfil">Perfil</a></li>
                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>Auth/logout">Cerrar Sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>