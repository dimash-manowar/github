<div class="container text-light">
    <h2 class="mb-4">Editar Perfil</h2>

    <form action="<?= BASE_URL ?>Perfil/actualizar" method="POST" enctype="multipart/form-data" novalidate><?= csrf_field() ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva Contraseña (dejar vacío si no se cambia)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto de perfil</label><br>
            <?php if (!empty($usuario['foto'])): ?>
                <img src="<?= BASE_URL ?>Assets/img/users/<?= $usuario['foto'] ?>" class="rounded mb-2" width="100"><br>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="<?= BASE_URL ?>Dashboard" class="btn btn-outline-secondary ms-2">Cancelar</a>
    </form>
</div>
