<?php include 'Views/Usuarios/topbar.php'; ?>
<div class="d-flex" id="wrapper">
  <?php include 'Views/Usuarios/sidebar.php'; ?>

  <div class="container-fluid p-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
      <h2 class="fw-bold m-0">Mis Cursos</h2>

      <form class="d-flex gap-2" method="get" action="<?= BASE_URL ?>Usuario/cursos">
        <select name="cat" class="form-select bg-black text-light" style="min-width:180px">
          <option value="">Todas las categorías</option>
          <?php foreach (['Unity','Web','Blender'] as $cat): ?>
            <option value="<?= $cat ?>" <?= ($filtro_cat ?? '')===$cat ? 'selected':'' ?>><?= $cat ?></option>
          <?php endforeach; ?>
        </select>
        <input type="text" name="q" class="form-control bg-black text-light" placeholder="Buscar cursos…" value="<?= htmlspecialchars($busqueda ?? '') ?>">
        <button class="btn btn-outline-light"><i class="bi bi-search"></i></button>
      </form>
    </div>

    <?php if (empty($cursos)): ?>
      <div class="alert alert-dark border-secondary">
        Aún no tienes cursos matriculados. ¿Quieres explorar <a href="<?= BASE_URL ?>">la página principal</a>?
      </div>
    <?php else: ?>

      <div class="row g-3" id="mis-cursos-grid">
        <?php foreach ($cursos as $c): 
          $portada = !empty($c['portada'])
                    ? BASE_URL . 'Assets/imagen/cursos/' . $c['portada']
                    : BASE_URL . 'Assets/imagen/usuario.jpg';
          $pct  = (int)($c['pct'] ?? 0);
          $comp = (int)($c['comp'] ?? 0);
          $tot  = (int)($c['total_lecciones'] ?? 0);
          $last = !empty($c['last_at']) ? date('d/m/Y H:i', strtotime($c['last_at'])) : '—';
          $nextId = (int)($c['next_id'] ?? 0);
        ?>
        <div class="col-md-6 col-xl-4">
          <div class="card bg-dark border-secondary h-100" data-cat="<?= htmlspecialchars($c['categoria']) ?>">
            <img src="<?= $portada ?>" class="card-img-top" style="aspect-ratio:16/9; object-fit:cover" alt="Portada">

            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start">
                <h5 class="card-title mb-1"><?= htmlspecialchars($c['titulo']) ?></h5>
                <span class="badge bg-secondary"><?= htmlspecialchars($c['categoria']) ?></span>
              </div>
              <div class="text-secondary small mb-2"><?= ucfirst($c['nivel']) ?></div>

              <div class="mb-2">
                <div class="progress" style="height:8px">
                  <div class="progress-bar bg-info" role="progressbar" style="width: <?= $pct ?>%" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small mt-1 text-secondary">
                  <span><?= $pct ?>% · <?= $comp ?>/<?= $tot ?> lecciones</span>
                  <span>Última actividad: <?= $last ?></span>
                </div>
              </div>

              <div class="mt-auto d-flex gap-2">
                <a href="<?= BASE_URL ?>Cursos/ver/<?= (int)$c['id'] ?>" class="btn btn-outline-light btn-sm">
                  <i class="bi bi-list-check me-1"></i> Ver curso
                </a>
                <?php if ($nextId): ?>
                <a href="<?= BASE_URL ?>Cursos/leccion/<?= (int)$c['id'] ?>/<?= $nextId ?>" class="btn btn-primary btn-sm">
                  <i class="bi bi-play-fill me-1"></i> Continuar
                </a>
                <?php else: ?>
                <a href="<?= BASE_URL ?>Cursos/ver/<?= (int)$c['id'] ?>" class="btn btn-primary btn-sm">
                  <i class="bi bi-play-fill me-1"></i> Empezar
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    <?php endif; ?>
  </div>
</div>
