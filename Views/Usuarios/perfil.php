<?php include 'Views/Usuarios/topbar.php'; ?>
<div class="d-flex" id="wrapper">
    <?php include 'Views/Usuarios/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <h2 class="fw-bold mb-4">Mi Perfil</h2>

        <form action="<?= BASE_URL ?>Usuario/perfil" method="POST" enctype="multipart/form-data" class="bg-dark p-4 rounded text-light" novalidate><?= csrf_field() ?>


            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= $_SESSION['user']['nombre'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="<?= $_SESSION['user']['apellido'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $_SESSION['user']['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-control" placeholder="Déjalo en blanco para no cambiarla">
            </div>

            <div class="mb-3">
                <label class="form-label">Foto de perfil</label><br>
                <img src="<?= BASE_URL ?>Assets/imagen/users/<?= $_SESSION['user']['foto'] ?>" class="rounded-circle mb-2" width="80" height="80">
                <input type="file" name="foto" class="form-control mt-2">
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</div>
