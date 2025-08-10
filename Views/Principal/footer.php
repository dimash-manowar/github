</main>

<!-- JS de terceros -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>
<script src="<?= BASE_URL ?>Assets/js/menusAuth.js?v=1"></script>

<!-- JS por página (si lo pasaste desde el controlador) -->
<?php if (!empty($page_functions_js)): ?>
<script src="<?= BASE_URL ?>Assets/js/<?= htmlspecialchars($page_functions_js) ?>?v=<?= time() ?>"></script>
<?php endif; ?>
<?php if (!empty($_SESSION['user'])): ?>
<script src="<?= BASE_URL ?>Assets/js/notifs.js?v=1"></script>
<?php endif; ?>
<!-- Alertas globales -->
 
<?php if (!empty($_SESSION['alert'])): ?>
<script>
Swal.fire({
  icon: '<?= $_SESSION['alert']['icon'] ?>',
  title: '<?= $_SESSION['alert']['title'] ?>',
  text: '<?= $_SESSION['alert']['text'] ?>'
});
</script>
<?php unset($_SESSION['alert']); endif; ?>

</body>
</html>
