<?php
$u = $_SESSION['user'] ?? [];
$foto = !empty($u['foto']) ? BASE_URL . 'Assets/imagen/users/' . $u['foto'] : BASE_URL . 'Assets/imagen/usuario.png';
$nombre = $u['nombre'] ?? 'Usuario';
$current = strtolower($_GET['url'] ?? '');

// helpers para “activo/abierto” en el menú
function isOpen($keys)
{
    global $current;
    foreach ((array)$keys as $k) {
        if (strpos($current, strtolower($k)) === 0) return ' show';
    }
    return '';
}
function active($keys)
{
    global $current;
    foreach ((array)$keys as $k) {
        if (strpos($current, strtolower($k)) === 0) return ' active fw-bold text-info';
    }
    return '';
}
?>
<div class="bg-black border-end" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 text-light">
        <img src="<?= htmlspecialchars($foto) ?>" class="rounded-circle mb-2" width="80" height="80" alt="avatar">
        <h6 class="mb-0"><?= htmlspecialchars($nombre) ?></h6>
        <small class="text-muted"><?= ucfirst($u['rol'] ?? 'usuario') ?></small>
    </div>

    <div class="list-group list-group-flush" id="userSidebarAccordion">
        <a href="<?= BASE_URL ?>Usuario" class="list-group-item list-group-item-action bg-dark text-white<?= active('usuario') ?>">
            🏠 Dashboard
        </a>
        <a href="<?= BASE_URL ?>Usuario/cursos" class="list-group-item list-group-item-action bg-dark text-white">🎓 Mis Cursos</a>

        <!-- Cursos Unity (colapsable) -->
        <a class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" href="#submenuUnityUser" role="button" aria-expanded="false" aria-controls="submenuUnityUser">
            🎮 Cursos Unity
            <i class="bi bi-chevron-down small"></i>
        </a>
        <div class="collapse ps-3" id="submenuUnityUser">
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_UNITY_3D ?>" class="list-group-item bg-secondary text-white">Unity 3D</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_UNITY_2D ?>" class="list-group-item bg-secondary text-white">Unity 2D</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_CSHARP   ?>" class="list-group-item bg-secondary text-white">Programación C#</a>
        </div>

        <!-- Cursos Web (colapsable) -->
        <a class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" href="#submenuWebUser" role="button" aria-expanded="false" aria-controls="submenuWebUser">
            💻 Cursos Web
            <i class="bi bi-chevron-down small"></i>
        </a>
        <div class="collapse ps-3" id="submenuWebUser">
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_WEB_HTMLCSS ?>" class="list-group-item bg-secondary text-white">HTML & CSS</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_WEB_JS      ?>" class="list-group-item bg-secondary text-white">JavaScript</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_WEB_PHP     ?>" class="list-group-item bg-secondary text-white">PHP & MySQL</a>
        </div>

        <!-- Cursos Blender (colapsable) -->
        <a class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" href="#submenuBlenderUser" role="button" aria-expanded="false" aria-controls="submenuBlenderUser">
            🧊 Cursos Blender
            <i class="bi bi-chevron-down small"></i>
        </a>
        <div class="collapse ps-3" id="submenuBlenderUser">
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_BLENDER_MODELADO    ?>" class="list-group-item bg-secondary text-white">Modelado</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_BLENDER_TEXTURIZADO ?>" class="list-group-item bg-secondary text-white">Texturizado</a>
            <a href="<?= BASE_URL ?>Cursos/ver/<?= CID_BLENDER_ANIMACION   ?>" class="list-group-item bg-secondary text-white">Animación</a>
        </div>


        <!-- 📈 Mi progreso (badge de pendientes) -->
        <a href="<?= BASE_URL ?>Usuario/progreso" class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center<?= active('usuario/progreso') ?>">
            📈 Mi progreso
            <span id="badge-pendientes" class="badge bg-info ms-2" style="display:none">0</span>
        </a>

        <!-- ⭐ Favoritos (badge de favoritos) -->
        <a href="<?= BASE_URL ?>Usuario/favoritos" class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center<?= active('usuario/favoritos') ?>">
            ⭐ Favoritos
            <span id="badge-favoritos" class="badge bg-warning text-dark ms-2" style="display:none">0</span>
        </a>

        <a href="<?= BASE_URL ?>Usuario/perfil" class="list-group-item list-group-item-action bg-dark text-white<?= active('usuario/perfil') ?>">👤 Mi Perfil</a>
        <a href="<?= BASE_URL ?>Auth/logout" class="list-group-item list-group-item-action bg-dark text-danger">🚪 Cerrar sesión</a>
    </div>

</div>