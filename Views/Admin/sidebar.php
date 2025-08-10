<?php include 'Views/Admin/headerAdmin.php'; ?>
<!-- Sidebar -->
<div class="bg-dark border-end sidebar-wrapper d-none d-lg-block" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 text-white">
        <img src="<?= BASE_URL ?>Assets/imagen/frontal.jpg" class="rounded-circle mb-2" width="80" height="80" alt="Usuario">
        <h6>Juan Pérez</h6>
        <small class="text-muted">Administrador</small>
    </div>
    <div class="list-group list-group-flush" id="sidebarAccordion">
        <a href="<?= BASE_URL ?>admin/index"
            class="list-group-item list-group-item-action bg-dark text-white <?= $seccion === 'admin' ? 'active fw-bold text-info' : '' ?>">
            🏠 Dashboard
        </a>
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


        <div class="collapse ps-3" data-bs-parent="#sidebarAccordion" id="submenuBlender">
            <a href="<?= BASE_URL ?>admin/blender/animacion" class="list-group-item bg-secondary text-white">Animacion</a>
            <a href="<?= BASE_URL ?>admin/blender/modelado" class="list-group-item bg-secondary text-white">Modelado</a>
            <a href="<?= BASE_URL ?>admin/blender/texturizado" class="list-group-item bg-secondary text-white">Texturizado</a>
        </div>
        <!-- Blog (menú colapsable) -->
        <a class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" href="#submenuBlog" role="button" aria-expanded="false" aria-controls="submenuBlog">
            🎮 Blog
            <i class="bi bi-chevron-down small"></i>
        </a>

        <div class="collapse ps-3" data-bs-parent="#sidebarAccordion" id="submenuBlog">
            <a href="<?= BASE_URL ?>admin/blog/destacado" class="list-group-item bg-secondary text-white">Destacado</a>
            <a href="<?= BASE_URL ?>admin/blog/ultimas" class="list-group-item bg-secondary text-white">Ultimas</a>
        </div>
        <!-- Galeria (menú colapsable) -->
        <a class="list-group-item list-group-item-action bg-dark text-white d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" href="#submenuGaleria" role="button" aria-expanded="false" aria-controls="submenuGaleria">
            🎮 Galeria
            <i class="bi bi-chevron-down small"></i>
        </a>
        <a href="<?= BASE_URL ?>admin/mensajes"
            class="list-group-item list-group-item-action bg-dark text-white <?= $seccion === 'admin' ? 'active fw-bold text-info' : '' ?>">
            🏠 Mensajes
        </a>
        <a href="<?= BASE_URL ?>admin/configuracion"
            class="list-group-item list-group-item-action bg-dark text-white <?= $seccion === 'admin' ? 'active fw-bold text-info' : '' ?>">
            🏠 Configuracion
        </a>
    </div>
</div>
<?php include 'Views/Admin/footerAdmin.php'; ?>