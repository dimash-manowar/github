</div> <!-- /#wrapper -->
<script>
  window.BASE_URL = "<?= rtrim(BASE_URL,'/') ?>/";
</script>

<!-- jQuery (para DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js (por si lo usas en paneles) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Notificaciones (campanita) solo si hay sesión -->
<?php if (!empty($_SESSION['user'])): ?>
<script src="<?= BASE_URL ?>Assets/js/notifs.js?v=1"></script>
<?php endif; ?>
<script src="<?= BASE_URL ?>Assets/js/adminNotificaciones.js?v=<?= time() ?>"></script>

<!-- Script específico de la página -->
<?php if (!empty($data['page_functions_js'])): ?>
<script src="<?= BASE_URL ?>Assets/js/<?= $data['page_functions_js'] ?>?v=<?= time(); ?>"></script>
<?php endif; ?>

<!-- Alertas de sesión -->
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
