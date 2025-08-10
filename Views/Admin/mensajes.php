<?php include 'Views/Admin/headerAdmin.php'; ?>
<div id="wrapper">
    <?php include 'Views/Admin/sidebar.php'; ?>
    <div id="page-content-wrapper">
        <?php include 'Views/Admin/topbar.php'; ?>

        <div class="container-fluid text-light">
            <h2 class="mt-4 mb-4">📬 <?= $page_title ?></h2>

            <div class="table-responsive bg-dark p-3 rounded shadow-sm">
                <table id="tablaMensajes" class="table table-dark table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Mensaje</th>
                            <th>Leído</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($mensajes as $msg): ?>
                            <tr>
                                <td><?= $msg['id'] ?></td>
                                <td><?= $msg['nombre'] ?></td>
                                <td><?= $msg['email'] ?></td>
                                <td><?= substr($msg['mensaje'], 0, 50) . '...' ?></td>
                                <td class="text-center">
                                    <?php if ($msg['leido']): ?>
                                        <span class="badge bg-success">Sí</span>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success marcar-leido" data-id="<?= $msg['id'] ?>">
                                            ✅ Marcar como leído
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger eliminar-mensaje" data-id="<?= $msg['id'] ?>">
                                        🗑️
                                    </button>
                                </td>

                                <td><?= date('d/m/Y H:i', strtotime($msg['creado_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'Views/Admin/footerAdmin.php'; ?>