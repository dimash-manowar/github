document.addEventListener('DOMContentLoaded', () => {
    const badge = document.getElementById('noti-badge');
    const list = document.getElementById('noti-list');
    const canvas = document.getElementById('offcanvasNoti');

    if (!badge || !list || !canvas) return;

    async function loadNotis() {
        try {
            const r = await fetch(`${window.BASE_URL}Admin/notificaciones`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const text = await r.text();               // 👈 primero como texto
            let data;
            try { data = JSON.parse(text); }           // 👈 luego parsear
            catch (e) {
                console.error('JSON inválido de Admin/notificaciones:', text);
                list.innerHTML = '<div class="text-danger small">Respuesta inválida del servidor.</div>';
                return;
            }

            const count = data.count ?? 0;
            // ... (resto igual)
        } catch (e) {
            console.error(e);
            list.innerHTML = '<div class="text-danger small">No se pudieron cargar las notificaciones.</div>';
        }
    }

    // Cargar al abrir el offcanvas
    canvas.addEventListener('show.bs.offcanvas', loadNotis);

    // Refrescar badge cada 60s (opcional)
    setInterval(loadNotis, 60000);

    // Cargar una vez al entrar
    loadNotis();
});
