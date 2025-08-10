(function(){
  let timer;

  function el(id){ return document.getElementById(id); }
  function fmtDate(s){ try{ return new Date(s).toLocaleString(); }catch{ return s; } }

  async function fetchCount(){
    try {
      const r = await fetch(`${window.BASE_URL}Notificaciones/unread`, { credentials: 'same-origin' });
      const d = await r.json();
      const c = parseInt(d.unread || 0, 10);
      const b = el('notif-count');
      if (!b) return;
      if (c > 0) { b.textContent = c; b.style.display = 'inline-block'; }
      else { b.style.display = 'none'; }
    } catch {}
  }

  async function fetchList(){
    try {
      const list = el('notif-list');
      if (!list) return;
      list.innerHTML = `<div class="p-3 text-secondary">Cargando…</div>`;
      const r = await fetch(`${window.BASE_URL}Notificaciones/list`, { credentials:'same-origin' });
      const d = await r.json();
      const items = d.items || [];
      if (!items.length) {
        list.innerHTML = `<div class="p-3 text-secondary">Sin notificaciones.</div>`;
        return;
      }
      list.innerHTML = items.map(n => `
        <a href="${n.link ? n.link : '#'}" class="dropdown-item d-flex align-items-start gap-2 notif-item ${n.leido?'':'bg-secondary bg-opacity-25'}" data-id="${n.id}">
          <i class="bi bi-bell"></i>
          <div>
            <div class="fw-semibold">${n.titulo}</div>
            ${n.cuerpo ? `<div class="small text-secondary">${n.cuerpo}</div>` : ''}
            <div class="small text-secondary">${fmtDate(n.creado_at)}</div>
          </div>
        </a>
      `).join('');

      // marcar leída al hacer click
      list.querySelectorAll('.notif-item').forEach(a => {
        a.addEventListener('click', async (e) => {
          const id = a.dataset.id;
          if (!id) return;
          try {
            await fetch(`${window.BASE_URL}Notificaciones/read`, {
              method:'POST',
              headers:{'Content-Type':'application/x-www-form-urlencoded'},
              body: new URLSearchParams({ id, csrf: window.CSRF })
            });
            // no bloqueamos la navegación; el mark se hace "best effort"
          } catch {}
        });
      });
    } catch {}
  }

  function startPolling(){
    clearInterval(timer);
    timer = setInterval(fetchCount, 60000); // cada 60s
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Sólo si tenemos la campana en la página
    if (!el('notif-count')) return;
    fetchCount(); startPolling();

    // Abrir dropdown -> cargar lista
    const dd = document.getElementById('notifDropdown');
    dd?.addEventListener('show.bs.dropdown', fetchList);

    // Marcar todas
    el('notif-markall')?.addEventListener('click', async () => {
      try {
        await fetch(`${window.BASE_URL}Notificaciones/readAll`, {
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body: new URLSearchParams({ csrf: window.CSRF })
        });
        fetchList(); fetchCount();
        if (window.Swal) Swal.fire({toast:true, position:'top-end', timer:1000, showConfirmButton:false, icon:'success', title:'¡Listo!'});
      } catch {}
    });
  });
})();
