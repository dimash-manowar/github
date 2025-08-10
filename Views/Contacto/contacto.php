<div class="container py-5">
    <h1 class="mb-4">Formulario de Contacto</h1>

    <form id="formContacto" method="POST" action="<?= BASE_URL ?>contacto/enviar" novalidate><?= csrf_field() ?>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>