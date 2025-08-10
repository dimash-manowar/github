<footer class="text-center text-secondary small mt-4">© <?= date('Y') ?> Orion3D</footer>
<script>
  window.BASE_URL = "<?= rtrim(BASE_URL,'/') ?>/";
  // CSRF para peticiones fetch desde vistas de usuario
  <?php
    if (empty($_SESSION['csrf'])) {
      $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
  ?>
  window.CSRF = "<?= $_SESSION['csrf'] ?>";
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Scripts personalizados del dashboard -->

<?php if (isset($data['page_functions_js'])): ?>
    <script src= "<?= BASE_URL?>Assets/js/<?= $data['page_functions_js']; ?>?v=<?= time(); ?>"></script>
<?php endif; ?>
<!-- Paquete de datos para JS externo -->
 

<?php if (!empty($_SESSION['alert'])): ?>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['icon'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        text: '<?= $_SESSION['alert']['text'] ?>',
        confirmButtonColor: '#3085d6'
    });
</script>
<?php unset($_SESSION['alert']); ?>
<?php endif; ?>

</body>
</html>