
<!-- Hero Section -->
<section class="bg-dark text-light text-center py-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Bienvenido a Orion3D</h1>
        <p class="lead mb-4">
            Aprende <strong>Programación Web</strong>, desarrolla <strong>Videojuegos con Unity</strong>
            y domina el <strong>Modelado 3D con Blender</strong>.
        </p>
        <a href="<?= BASE_URL ?>contacto" class="btn btn-primary btn-lg">¡Comienza ahora!</a>
    </div>
</section>

<!-- Especialidades -->
<section class="bg-black text-light py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-dark">
                    <i class="bi bi-code-slash fs-1 text-primary"></i>
                    <h3 class="mt-3">Programación Web</h3>
                    <p>
                        Aprende a crear sitios modernos y funcionales con PHP, JavaScript, HTML y CSS, usando buenas prácticas de desarrollo.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-dark">
                    <i class="bi bi-controller fs-1 text-success"></i>
                    <h3 class="mt-3">Videojuegos con Unity</h3>
                    <p>
                        Diseña e implementa videojuegos 2D y 3D desde cero usando el motor Unity y el lenguaje C#.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-dark">
                    <i class="bi bi-cube fs-1 text-warning"></i>
                    <h3 class="mt-3">Modelado 3D con Blender</h3>
                    <p>
                        Domina las herramientas de modelado, texturizado y animación en Blender para tus proyectos creativos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sobre Orion3D -->
<section class="bg-dark text-light py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <h2 class="fw-bold">¿Qué es Orion3D?</h2>
                <p>
                    Orion3D es un espacio donde combinamos programación, desarrollo de videojuegos y modelado 3D para crear experiencias únicas.
                    Aquí aprenderás desde los fundamentos hasta técnicas avanzadas, con ejemplos prácticos y proyectos reales.
                </p>
                <a href="<?= BASE_URL ?>contacto" class="btn btn-outline-light">Contáctanos</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?= BASE_URL ?>Assets/imagen/Logo.png" alt="Orion3D" class="img-fluid rounded" style="max-height: 250px;">
            </div>
        </div>
    </div>
</section>

<!-- Llamada a la acción final -->
<section class="bg-black text-light text-center py-5">
    <div class="container">
        <h2 class="fw-bold mb-3">¿Listo para crear algo increíble?</h2>
        <a href="<?= BASE_URL ?>contacto" class="btn btn-primary btn-lg">¡Hablemos!</a>
    </div>
</section>
<!-- Galería de Imágenes -->
<section class="bg-dark text-light py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Galería Orion3D</h2>

        <!-- Swiper Slider -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php for($i=1; $i<=6; $i++): ?>
                <div class="swiper-slide">
                    <a href="<?= BASE_URL ?>Assets/imagen/armadura<?= $i ?>.jpg" class="glightbox">
                        <img src="<?= BASE_URL ?>Assets/imagen/armadura<?= $i ?>.jpg" 
                             alt="Galería Orion3D <?= $i ?>" 
                             class="img-fluid rounded shadow-sm">
                    </a>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Botones de navegación -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- Testimonios -->
<section class="bg-gradient-testimonios text-light py-5">
    <div class="container-testimonios">
        <h2 class="fw-bold text-center mb-5" data-aos="fade-up">Lo que dicen nuestros usuarios</h2>
        <div class="row g-4 text-center">

            <div class="col-md-4" data-aos="fade-right">
                <div class="p-4 rounded shadow-sm bg-black h-100">
                    <i class="bi bi-chat-quote fs-1 text-primary"></i>
                    <p class="mt-3">"Gracias a Orion3D aprendí a desarrollar mi primer videojuego."</p>
                    <footer class="blockquote-footer text-light mt-2">Carlos M.</footer>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in">
                <div class="p-4 rounded shadow-sm bg-black h-100">
                    <i class="bi bi-chat-quote fs-1 text-success"></i>
                    <p class="mt-3">"Los tutoriales de modelado 3D son claros y prácticos."</p>
                    <footer class="blockquote-footer text-light mt-2">Lucía R.</footer>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-left">
                <div class="p-4 rounded shadow-sm bg-black h-100">
                    <i class="bi bi-chat-quote fs-1 text-warning"></i>
                    <p class="mt-3">"Ahora puedo crear webs modernas y atractivas."</p>
                    <footer class="blockquote-footer text-light mt-2">Miguel S.</footer>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Galería de Videos -->
<section class="bg-black text-light py-5">
    <div class="container-videos">
        <h2 class="fw-bold text-center mb-4">Videos Cortos</h2>

        <div class="swiper mySwiperVideos">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="<?= BASE_URL ?>Assets/video/dimash.mp4" class="glightbox" data-type="video">
                        <video class="w-100 rounded shadow-sm" muted loop>
                            <source src="<?= BASE_URL ?>Assets/video/" type="video/mp4">
                        </video>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="<?= BASE_URL ?>Assets/video/dimash1.mp4" class="glightbox" data-type="video">
                        <video class="w-100 rounded shadow-sm" muted loop>
                            <source src="<?= BASE_URL ?>Assets/video/" type="video/mp4">
                        </video>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="https://www.youtube.com/watch?v=VIDEO_ID" class="glightbox" data-type="video">
                        <img src="<?= BASE_URL ?>Assets/imagen/alien5.jpg" class="img-fluid rounded shadow-sm">
                    </a>
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<footer class="footer-orion3d bg-black text-light pt-5 pb-3">
    <div class="container">
        <div class="row gy-4">
            
            <!-- Logo y descripción -->
            <div class="col-md-4">
                <h3 class="fw-bold mb-3">Orion3D</h3>
                <p>
                    Aprende programación web, desarrollo de videojuegos con Unity y modelado 3D con Blender.
                    Un espacio para creadores digitales.
                </p>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Enlaces rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>" class="footer-link">Inicio</a></li>
                    <li><a href="<?= BASE_URL ?>contacto" class="footer-link">Contacto</a></li>
                    <li><a href="#" class="footer-link">Cursos</a></li>
                    <li><a href="#" class="footer-link">Blog</a></li>
                </ul>
            </div>

            <!-- Suscripción -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Suscríbete</h5>
                <form id="formSuscripcion" class="d-flex flex-column">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="btn btn-primary">Suscribirme</button>
                </form>
                <div class="mt-3">
                    <a href="#" class="social-link me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-link me-3"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

        </div>

        <!-- Línea inferior -->
        <hr class="border-secondary my-4">
        <div class="text-center">
            <small>&copy; <?= date("Y") ?> Orion3D. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>




