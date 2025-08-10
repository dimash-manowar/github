<?php
$isAuth  = !empty($_SESSION['user']);
$lockCls = $isAuth ? '' : ' need-auth';

// Base para construir links de paginación conservando filtros
$qs = $_GET; unset($qs['page']);
$qsBase = http_build_query($qs);
$base   = BASE_URL.'Cursos'.(strlen($qsBase)?'?'.$qsBase.'&':'?');
?>
<div class="container py-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="fw-bold m-0">Catálogo de cursos</h1>

    <form class="d-flex flex-wrap gap-2 align-items-center" method="get" action="<?= BASE_URL ?>Cursos" id="catalogoForm">
      <select name="cat" class="form-select bg-black text-light" style="min-width:160px">
        <option value="">Todas las categorías</option>
        <?php foreach (($categorias ?? []) as $c): ?>
          <option value="<?= $c ?>" <?= (($filtro_cat ?? '')===$c?'selected':'') ?>><?= $c ?></option>
        <?php endforeach; ?>
      </select>

      <select name="lvl" class="form-select bg-black text-light" style="min-width:160px">
        <option value="">Todos los niveles</option>
        <?php foreach (($niveles ?? []) as $n): ?>
          <option value="<?= $n ?>" <?= (($filtro_lvl ?? '')===$n?'selected':'') ?>><?= ucfirst($n) ?></option>
        <?php endforeach; ?>
      </select>

      <input type="text" name="q" class="form-control bg-black text-light" placeholder="Buscar…" value="<?= htmlspecialchars($busqueda ?? '') ?>" style="min-width:220px">

      <select name="sort" class="form-select bg-black text-light">
        <option value="recientes"  <?= ($sort==='recientes'?'selected':'') ?>>Recientes</option>
        <option value="populares"  <?= ($sort==='populares'?'selected':'') ?>>Populares</option>
        <option value="titulo"     <?= ($sort==='titulo'   ?'selected':'') ?>>Título (A–Z)</option>
      </select>

      <select name="per" class="form-select bg-black text-light">
        <?php foreach ([6,9,12,18] as $n): ?>
          <option value="<?= $n ?>" <?= ($per==$n?'selected':'') ?>><?= $n ?>/página</option>
        <?php endforeach; ?>
      </select>

      <button class="btn btn-outline-light"><i class="bi bi-search"></i></button>
    </form>
  </div>

  <?php if (empty($cursos)): ?>
    <div class="alert alert-dark border-secondary">No encontramos cursos con esos filtros.</div>
  <?php else: ?>
    <div class="row g-3" id="catalogo-grid">
      <?php foreach ($cursos as $c):
        $img = !empty($c['portada'])
              ? BASE_URL . 'Assets/imagen/cursos/' . $c['portada']
              : BASE_URL . 'Assets/imagen/usuario.png';
        $href = $isAuth ? (BASE_URL.'Cursos/ver/'.(int)$c['id']) : '#';
        $alum = (int)($c['alumnos'] ?? 0);
        $less = (int)($c['total_lecciones'] ?? 0);
      ?>
      <div class="col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary h-100" data-cat="<?= htmlspecialchars($c['categoria']) ?>" data-lvl="<?= htmlspecialchars($c['nivel']) ?>">
          <img src="<?= $img ?>" class="card-img-top" style="aspect-ratio:16/9; object-fit:cover" alt="Portada">

          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start">
              <h5 class="card-title mb-1"><?= htmlspecialchars($c['titulo']) ?></h5>
              <span class="badge bg-secondary"><?= htmlspecialchars($c['categoria']) ?></span>
            </div>
            <div class="text-secondary small mb-2">
              <?= ucfirst($c['nivel']) ?> · <?= $less ?> lecciones · <i class="bi bi-people"></i> <?= $alum ?> alumnos
            </div>
            <?php if (!empty($c['resumen'])): ?>
              <p class="text-secondary small mb-3"><?= htmlspecialchars($c['resumen']) ?><?= strlen($c['resumen'])>=160?'…':'' ?></p>
            <?php endif; ?>

            <div class="mt-auto">
              <a href="<?= $href ?>" 
                 class="btn btn-primary w-100<?= $lockCls ?>" 
                 data-target="<?= htmlspecialchars($c['titulo']) ?>">
                <i class="bi bi-play-fill me-1"></i> Ver curso
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <?php if (($total_pages ?? 1) > 1): ?>
      <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-center">
          <li class="page-item <?= ($page<=1?'disabled':'') ?>">
            <a class="page-link" href="<?= $base.'page='.max(1,$page-1) ?>" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a>
          </li>
          <?php
            $start = max(1, $page-2);
            $end   = min($total_pages, $page+2);
            for ($p=$start; $p<=$end; $p++):
          ?>
            <li class="page-item <?= ($p==$page?'active':'') ?>">
              <a class="page-link" href="<?= $base.'page='.$p ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= ($page>=$total_pages?'disabled':'') ?>">
            <a class="page-link" href="<?= $base.'page='.min($total_pages,$page+1) ?>" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a>
          </li>
        </ul>
      </nav>
      <div class="text-center text-secondary small">
        Mostrando <?= count($cursos) ?> de <?= (int)$total ?> cursos · Página <?= (int)$page ?>/<?= (int)$total_pages ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
