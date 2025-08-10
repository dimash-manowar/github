<?php
$u = $_SESSION['user'] ?? [];
$nombre = $u['nombre'] ?? $u['name'] ?? 'Usuario';
$foto = !empty($u['foto']) ? BASE_URL.'Assets/imagen/users/'.$u['foto'] : BASE_URL.'Assets/imagen/usuario.png';
$resumen   = $payload['resumen']   ?? ['cursos'=>0,'lecciones_tot'=>0,'lecciones_comp'=>0,'progreso_pct'=>0,'horas_semana'=>0];
$actividad = $payload['actividad'] ?? ['labels'=>['L','M','X','J','V','S','D'], 'horas'=>[0,0,0,0,0,0,0]];
$cursos    = $payload['cursos']    ?? [];
?>
<?php include 'Views/Usuarios/topbar.php'; ?>
<div class="d-flex" id="wrapper">
  <?php include 'Views/Usuarios/sidebar.php'; ?>

  <div class="container-fluid p-4">

    <div class="bg-dark border rounded-3 p-3 mb-4">
      <div class="d-flex align-items-center gap-3">
        <img src="<?= htmlspecialchars($foto) ?>" class="rounded-circle border" width="56" height="56" alt="">
        <div>
          <h1 class="h5 mb-1">Hola, <?= htmlspecialchars($nombre) ?></h1>
          <div class="text-secondary">Aquí va tu progreso global</div>
        </div>
      </div>
    </div>

    <!-- KPIs -->
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="bg-dark border rounded-3 p-3 h-100">
          <div class="text-secondary small">Cursos</div>
          <div class="fs-4 fw-semibold" id="kpi-cursos"><?= (int)$resumen['cursos'] ?></div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="bg-dark border rounded-3 p-3 h-100">
          <div class="text-secondary small">Progreso</div>
          <div class="fs-4 fw-semibold"><span id="kpi-progreso"><?= (int)$resumen['progreso_pct'] ?></span>%</div>
          <div class="progress mt-2" style="height:6px;">
            <div id="kpi-progreso-bar" class="progress-bar" style="width: <?= (int)$resumen['progreso_pct'] ?>%"></div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="bg-dark border rounded-3 p-3 h-100">
          <div class="text-secondary small">Lecciones</div>
          <div class="fs-6">
            <span id="kpi-lec-comp"><?= (int)$resumen['lecciones_comp'] ?></span>
            /
            <span id="kpi-lec-tot"><?= (int)$resumen['lecciones_tot'] ?></span>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="bg-dark border rounded-3 p-3 h-100">
          <div class="text-secondary small">Horas (semana)</div>
          <div class="fs-4 fw-semibold" id="kpi-horas"><?= (int)$resumen['horas_semana'] ?></div>
        </div>
      </div>
    </div>

    <!-- Actividad semanal -->
    <div class="bg-dark border rounded-3 p-3 mt-3">
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="h6 m-0">Actividad semanal (horas)</h2>
        <span class="badge bg-secondary">Últimos 7 días</span>
      </div>
      <canvas id="chartProgreso" height="120" class="mt-3"></canvas>
    </div>

    <!-- Tus cursos -->
    <div class="bg-dark border rounded-3 p-3 mt-3">
      <h2 class="h6">Tus cursos</h2>
      <div class="table-responsive mt-2">
        <table class="table table-dark table-striped align-middle mb-0" id="tablaCursos">
          <thead><tr>
            <th>Curso</th><th>Progreso</th><th>Lecciones</th><th>Último acceso</th><th>Acciones</th>
          </tr></thead>
          <tbody>
            <?php foreach ($cursos as $c): ?>
              <tr>
                <td><?= htmlspecialchars($c['titulo']) ?></td>
                <td><?= (int)$c['progreso'] ?>%</td>
                <td><?= (int)$c['lecciones_comp'] ?>/<?= (int)$c['lecciones_tot'] ?></td>
                <td><?= $c['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($c['ultimo_acceso'])) : '-' ?></td>
                <td>
                  <a class="btn btn-sm btn-outline-light" href="<?= BASE_URL ?>cursos/ver/<?= (int)$c['id'] ?>">
                    <i class="bi bi-play-fill me-1"></i>Continuar
                  </a>
                  <button class="btn btn-sm btn-outline-warning btn-fav" data-type="curso" data-id="<?= (int)$c['id'] ?>">
                    <i class="bi bi-star"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Payload para el JS -->
<script id="progreso-data" type="application/json">
<?= json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>
</script>
