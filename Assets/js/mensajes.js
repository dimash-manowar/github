document.addEventListener('DOMContentLoaded', function () {
    $('#tablaMensajes').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });


    // Marcar como leído
    document.querySelectorAll('.marcar-leido').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            Swal.fire({
                title: '¿Marcar como leído?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`<?= BASE_URL ?>adminMensajes/marcarLeido/${id}`)
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                Swal.fire('Actualizado', res.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        });
                }
            });
        });
    });

    // Eliminar mensaje
    document.querySelectorAll('.eliminar-mensaje').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            Swal.fire({
                title: '¿Eliminar mensaje?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`<?= BASE_URL ?>adminMensajes/eliminar/${id}`)
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                Swal.fire('Eliminado', res.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        });
                }
            });
        });
    });
});
