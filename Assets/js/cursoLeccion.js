document.addEventListener('DOMContentLoaded', () => {
  // ---------- Q U I L L  ----------
  const editorEl = document.getElementById('qna-editor');
  // Si esta vista no tiene editor, salimos (evita "Invalid container")
  if (editorEl) {
    // Evitar doble init si el script se incluye dos veces
    if (editorEl.dataset.quillInit !== '1') {
      const initQuill = () => {
        try {
          const q = new Quill(editorEl, {
            theme: 'snow',
            placeholder: 'Escribe tu duda con detalles…',
            modules: {
              toolbar: [
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'code-block'],
                ['clean']
              ]
            }
          });
          editorEl.dataset.quillInit = '1';
          attachQnaHandlers(q);
        } catch (e) {
          console.error('Error iniciando Quill:', e);
        }
      };

      // Si Quill no está cargado aún, lo cargamos dinámicamente (fallback)
      if (!window.Quill) {
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js';
        s.onload = initQuill;
        document.head.appendChild(s);
      } else {
        initQuill();
      }
    }
  }

  // ---------- R E S T O  ----------
  function attachQnaHandlers(q){
    const btnSend = document.getElementById('qna-send');
    const file    = document.getElementById('qna-img');
    const list    = document.getElementById('qna-list');

    const root = document.getElementById('leccion-root');
    const cursoId   = parseInt(root?.dataset.cursoId || '0', 10);
    const leccionId = parseInt(root?.dataset.leccionId || '0', 10);

    btnSend?.addEventListener('click', async () => {
      const html = q.root.innerHTML.trim();
      if (!html || html === '<p><br></p>') {
        return Swal?.fire('Vacío','Escribe tu pregunta antes de enviar.','info');
      }
      const fd = new FormData();
      fd.append('csrf', window.CSRF);
      fd.append('curso_id', cursoId);
      fd.append('leccion_id', leccionId);
      fd.append('contenido_html', html);
      if (file?.files?.[0]) fd.append('imagen', file.files[0]);

      btnSend.disabled = true;
      try {
        // OJO con la ruta (ver nota al final)
        const r = await fetch(`${window.BASE_URL}Cursos/preguntar`, { method:'POST', body: fd });
        const data = await r.json();
        if (!data.success) throw new Error();

        const wrap = document.createElement('div');
        wrap.className = 'p-3 mb-2 bg-black rounded border';
        wrap.innerHTML = `
          <div class="small text-secondary mb-1">Tú · ahora</div>
          <div class="qna-content">${data.item.contenido_html}</div>
          ${data.item.imagen ? `<div class="mt-2"><img src="${window.BASE_URL}${data.item.imagen}" class="img-fluid rounded"></div>` : '' }
        `;
        list?.prepend(wrap);
        q.setContents([]); if (file) file.value = '';
        Swal?.fire({toast:true, position:'top-end', timer:1500, showConfirmButton:false, icon:'success', title:'Pregunta enviada'});
      } catch {
        Swal?.fire('Error','No se pudo enviar tu pregunta.','error');
      } finally {
        btnSend.disabled = false;
      }
    });

    // Toggle Completada (tu código intacto)
    const chk = document.getElementById('chkDone');
    chk?.addEventListener('change', async () => {
      const estado = chk.checked ? 1 : 0;
      try {
        const body = new URLSearchParams({ csrf: window.CSRF, leccion_id: leccionId, estado });
        // OJO con la ruta (ver nota al final)
        const r = await fetch(`${window.BASE_URL}Cursos/toggleLeccion`, {
          method: 'POST',
          headers: { 'Content-Type':'application/x-www-form-urlencoded' },
          body
        });
        const data = await r.json();
        if (!data || !data.success) throw new Error();

        if (data.curso) {
          const pct  = data.curso.pct ?? 0;
          const comp = data.curso.comp ?? 0;
          const tot  = data.curso.tot ?? 0;
          const bar  = document.getElementById('prog-minibar');
          const txt  = document.getElementById('prog-mini-text');
          if (bar) bar.style.width = pct + '%';
          if (txt) txt.textContent = `${pct}% (${comp}/${tot})`;
        }

        if (data.resumen) {
          const p   = data.resumen.progreso_pct ?? 0;
          const lc  = data.resumen.lecciones_comp ?? 0;
          const lt  = data.resumen.lecciones_tot ?? 0;
          const kpiProg    = document.getElementById('kpi-progreso');
          const kpiProgBar = document.getElementById('kpi-progreso-bar');
          const kpiLComp   = document.getElementById('kpi-lec-comp');
          const kpiLTot    = document.getElementById('kpi-lec-tot');
          if (kpiProg)    kpiProg.textContent = p;
          if (kpiProgBar) kpiProgBar.style.width = p + '%';
          if (kpiLComp)   kpiLComp.textContent = lc;
          if (kpiLTot)    kpiLTot.textContent = lt;
        }

        if (data.badges) {
          const bPend = document.getElementById('badge-pendientes');
          if (bPend) {
            const n = data.badges.pendientes ?? 0;
            bPend.textContent = n;
            bPend.style.display = n > 0 ? 'inline-block' : 'none';
          }
        }

        Swal?.fire({toast:true, position:'top-end', timer:1000, showConfirmButton:false,
          icon: estado ? 'success' : 'info',
          title: estado ? 'Lección completada' : 'Lección desmarcada'
        });
      } catch {
        Swal?.fire('Error','No se pudo actualizar la lección.','error');
        chk.checked = !chk.checked;
      }
    });
  }
});
