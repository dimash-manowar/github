<?php if (!isset($pageTitle)) {
    $pageTitle = "Orion3D";
} ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">


    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Estilos propios -->    
    <link rel="stylesheet" href="<?= BASE_URL ?>Assets/css/orion3d_usuarios.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black py-3 shadow-sm">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary" href="<?= BASE_URL ?>">Orion3D</a>

            <!-- Links del menú -->
            <div class="collapse navbar-collapse" id="navbarOrion3D">
                <ul class="navbar-nav ms-auto">

                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>">Inicio</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Menús restringidos solo para usuarios logueados -->
                        <!-- Programación Web -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="progWebMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Programación Web
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="progWebMenu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>programacionWeb/html_css">HTML & CSS</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>programacionWeb/javascript">JavaScript</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>programacionWeb/php_mysql">PHP & MySQL</a></li>
                            </ul>
                        </li>

                        <!-- Unity -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="unityMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Videojuegos con Unity
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="unityMenu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>unity/unity2d">Unity 2D</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>unity/unity3d">Unity 3D</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>unity/recursos">Recursos y Scripts</a></li>
                            </ul>
                        </li>

                        <!-- Blender -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="blenderMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Modelado 3D con Blender
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="blenderMenu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>blender/modelado">Modelado</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>blender/texturizado">Texturizado</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>blender/animacion">Animación</a></li>
                            </ul>
                        </li>

                        <!-- Blog -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="blogMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Blog / Noticias
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="blogMenu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>blog/ultimas">Últimas Noticias</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>blog/destacados">Artículos Destacados</a></li>
                            </ul>
                        </li>

                        <!-- Contacto -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>contacto">Contacto</a>
                        </li>

                        <!-- Admin -->
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'usuario'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="<?= BASE_URL ?>Usuario">Usuario</a>
                            </li>
                        <?php endif; ?>
                        <!-- Logout -->
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#" id="logoutBtn" data-url="<?= BASE_URL ?>Logout">Salir</a>
                        </li>

                    <?php else: ?>
                        <!-- Solo visible si no está logueado -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>Auth">Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>Auth/register">Registrarse</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </nav>
