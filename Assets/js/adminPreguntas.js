document.addEventListener('DOMContentLoaded', () => {
  const detail = document.getElementById('qna-detail');
  if (!detail) return;
  const CSRF = detail.dataset.csrf;

  // Cargar hilo al hacer click
  document.querySelectorAll('.qna-item').forEach(it => {
    it.addEventListener('click', async (e) => {
      e.preventDefault();
      const id = it.dataset.id;
      if (!id) return;
      await loadThread(id);
      // marcar como leído
      fetch(`${window.BASE_URL}Admin/setLeidoQna`, {
        method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ id, leido:1, csrf: CSRF })
      }).catch(()=>{});
      // visualmente quitar "Nuevo"
      it.querySelector('.badge.bg-success')?.remove();
    });
  });

  async function loadThread(id){
    detail.innerHTML = `<div class="text-secondary">Cargando…</div>`;
    const r = await fetch(`${window.BASE_URL}Admin/verQna/${id}`);
    const data = await r.json();
    if (!data || !data.pregunta) {
      detail.innerHTML = `<div class="text-danger">No se pudo cargar el detalle.</div>`;
      return;
    }
    renderThread(data);
  }

  function renderThread({pregunta, respuestas}){
    const avatar = pregunta.foto ? `${window.BASE_URL}Assets/imagen/users/${pregunta.foto}` : `${window.BASE_URL}Assets/imagen/usuario.png`;
    const imgPreg = pregunta.imagen ? `<div class="mt-2"><img src="${window.BASE_URL}${pregunta.imagen}" class="img-fluid rounded"></div>` : '';
    const answers = (respuestas||[]).map(r => `
      <div class="p-3 bg-black rounded border mb-2">
        <div class="small text-secondary mb-1">Respuesta de ${r.admin_nombre || r.admin_usuario || 'Admin'} · ${new Date(r.creado_at).toLocaleString()}</div>
        <div>${r.contenido_html}</div>
        ${r.imagen ? `<div class="mt-2"><img src="${window.BASE_URL}${r.imagen}" class="img-fluid rounded"></div>` : ''}
      </div>
    `).join('');

    detail.innerHTML = `
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="d-flex align-items-center gap-2">
          <img src="${avatar}" class="rounded-circle" width="40" height="40">
          <div>
            <div class="small">${pregunta.nombre_usuario || pregunta.nombre || 'Alumno'}</div>
            <div class="text-secondary small">${pregunta.leccion_titulo || 'Lección'} · ${new Date(pregunta.creado_at).toLocaleString()}</div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <select id="qna-estado" class="form-select form-select-sm bg-black text-light" style="width:auto">
            ${['abierta','respondida','cerrada'].map(s => `<option value="${s}" ${pregunta.estado===s?'selected':''}>${s.charAt(0).toUpperCase()+s.slice(1)}</option>`).join('')}
          </select>
          <button class="btn btn-sm btn-outline-light" id="qna-refresh"><i class="bi bi-arrow-repeat"></i></button>
        </div>
      </div>

      <div class="p-3 bg-dark rounded border mb-2">
        <div>${pregunta.contenido_html}</div>
        ${imgPreg}
      </div>

      ${answers || '<div class="text-secondary">Sin respuestas todavía.</div>'}

      <hr class="border-secondary">
      <div class="mb-2 small text-secondary">Responder al alumno</div>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css">
      <div id="admin-editor" class="bg-white text-dark rounded"></div>
      <div class="mt-2 d-flex align-items-center gap-2">
        <input type="file" id="admin-img" accept="image/*" class="form-control form-control-sm" style="max-width:280px">
        <button class="btn btn-primary btn-sm" id="admin-send">Enviar</button>
        <input type="hidden" id="qna-id" value="${pregunta.id}">
      </div>
    `;

    // init quill (cargamos JS si no existe)
    if (!window.Quill) {
      const s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js';
      s.onload = initEditor; document.body.appendChild(s);
    } else { initEditor(); }

    function initEditor(){
      const q = new Quill('#admin-editor', {
        theme:'snow',
        placeholder:'Escribe una respuesta clara y concreta…',
        modules:{ toolbar: [['bold','italic','underline'], [{'list':'ordered'},{'list':'bullet'}], ['link','code-block'], ['clean']] }
      });

      document.getElementById('admin-send')?.addEventListener('click', async () => {
        const html = q.root.innerHTML.trim();
        if (!html || html === '<p><br></p>') { return Swal?.fire('Vacío','Escribe tu respuesta.','info'); }
        const id  = document.getElementById('qna-id').value;
        const img = document.getElementById('admin-img');

        const fd = new FormData();
        fd.append('csrf', CSRF);
        fd.append('pregunta_id', id);
        fd.append('contenido_html', html);
        if (img?.files?.[0]) fd.append('imagen', img.files[0]);

        try {
          const r = await fetch(`${window.BASE_URL}Admin/responderQna`, { method:'POST', body: fd });
          const d = await r.json();
          if (!d.success) throw new Error();

          Swal?.fire({toast:true, position:'top-end', timer:1500, showConfirmButton:false, icon:'success', title:'Respuesta enviada'});
          // recargar hilo
          loadThread(id);
        } catch {
          Swal?.fire('Error','No se pudo enviar la respuesta.','error');
        }
      });

      document.getElementById('qna-estado')?.addEventListener('change', async (ev) => {
        const estado = ev.target.value;
        const id = document.getElementById('qna-id').value;
        const r = await fetch(`${window.BASE_URL}Admin/setEstadoQna`, {
          method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body: new URLSearchParams({ id, estado, csrf: CSRF })
        });
        const ok = (await r.json())?.success;
        if (!ok) { Swal?.fire('Error','No se pudo cambiar el estado.','error'); return; }
        Swal?.fire({toast:true, position:'top-end', timer:1000, showConfirmButton:false, icon:'success', title:'Estado actualizado'});
      });

      document.getElementById('qna-refresh')?.addEventListener('click', () => {
        const id = document.getElementById('qna-id').value;
        loadThread(id);
      });
    }
  }
});
