<!-- Views/Usuarios/favoritos.php -->
<?php include 'Views/Usuarios/topbar.php'; ?>
<div class="d-flex" id="wrapper">
  <?php include 'Views/Usuarios/sidebar.php'; ?>
  <div class="container-fluid p-4">
    <h2 class="h5 mb-3">⭐ Favoritos</h2>
    <div class="bg-dark border rounded-3 p-3">
      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle mb-0" id="tablaFavoritos">
          <thead><tr><th>Tipo</th><th>Título</th><th>Último acceso</th><th>Acciones</th></tr></thead>
          <tbody>
            <!-- Cárgalo por JS o desde el controlador cuando tengas la BD lista -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
