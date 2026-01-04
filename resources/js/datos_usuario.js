async function cargarSuscripcion() {
  try {
    const res = await fetch('/api/empresa/suscripcion/status', {
      headers: { 'Accept': 'application/json' },
      credentials: 'same-origin'
    });

    const json = await res.json();

    if (json.errorCode !== 0) {
      localStorage.removeItem('empresaSuscripcion');
      renderNavSuscripcion();
      return null;
    }

    localStorage.setItem('empresaSuscripcion', JSON.stringify(json.msg));
    renderNavSuscripcion();
    return json.msg;
  } catch (e) {
    console.error('[suscripcion] error:', e);
    renderNavSuscripcion();
    return null;
  }
}

async function cargarSucursales() {
  try {
    const res = await fetch('/sucursal/fetch?per_page=1000&page=1', {
      headers: { 'Accept': 'application/json' },
      credentials: 'same-origin'
    });
    if (!res.ok) throw new Error('No se pudieron cargar sucursales');
    const json = await res.json();
    const lista = Array.isArray(json?.data) ? json.data : (Array.isArray(json) ? json : []);
    localStorage.setItem('sucursalesEmpresa', JSON.stringify(lista));
    return lista;
  } catch (e) {
    console.error('[sucursales] error:', e);
    localStorage.removeItem('sucursalesEmpresa');
    return [];
  }
}

function formatFechaDMY(fechaISO) {
  if (!fechaISO) return '';
  const soloFecha = String(fechaISO).split(' ')[0];
  const [y, m, d] = soloFecha.split('-');
  return `${d}/${m}/${y}`;
}

function renderNavSuscripcion() {
  const badge = document.getElementById('suscripcionBadge');
  const detalle = document.getElementById('suscripcionDetalle');
  if (!badge || !detalle) return;

  const data = JSON.parse(localStorage.getItem('empresaSuscripcion') || 'null');

  // default
  badge.className = 'badge text-uppercase bg-label-secondary';
  badge.textContent = 'CARGANDO';
  detalle.textContent = '';

  if (!data) {
    badge.className = 'badge text-uppercase bg-label-warning';
    badge.textContent = 'SIN DATOS';
    detalle.textContent = 'No se pudo cargar suscripción';
    return;
  }

  if (!data.activo) {
    badge.className = 'badge text-uppercase bg-label-danger';
    badge.textContent = 'VENCIDO';
    detalle.textContent = 'Renueva tu plan para continuar';
    return;
  }

  const plan = data?.suscripcion?.plan_nombre ?? 'PLAN';
  const finISO = data?.suscripcion?.fecha_fin;

  if (!finISO) {
    badge.className = 'badge text-uppercase bg-label-success';
    badge.textContent = plan;
    detalle.textContent = 'Ilimitado';
    return;
  }

  const fin = formatFechaDMY(finISO);
  const dias = data?.dias_restantes;

  badge.className = 'badge text-uppercase bg-label-primary';
  badge.textContent = plan;

  if (typeof dias === 'number') {
    detalle.textContent = `Vence ${fin} · faltan ${dias} día${dias === 1 ? '' : 's'}`;
  } else {
    detalle.textContent = `Vence ${fin}`;
  }
}

// pinta rápido y luego actualiza
renderNavSuscripcion();
cargarSuscripcion().then(() => {
  habilitarBloqueoPorNavegacion();
});
// Precarga sucursales para uso global en las vistas
cargarSucursales();


function mostrarAlertaSuscripcionVencida(data) {
  const overlay = document.getElementById('suscripcionOverlay');
  const msgEl = document.getElementById('suscripcionOverlayMsg');

  if (!overlay || !msgEl) {
    alert('Tu suscripción está vencida. Renueva para continuar.');
    return;
  }

  const plan = data?.suscripcion?.plan_nombre
    ? ` (${data.suscripcion.plan_nombre})`
    : '';

  const fin = data?.suscripcion?.fecha_fin
    ? `Venció el ${formatFechaDMY(data.suscripcion.fecha_fin)}`
    : 'Sin fecha de vencimiento';

  msgEl.innerHTML = `
    <strong>Acceso restringido</strong><br>
    Tu suscripción${plan} está vencida.<br>
    ${fin}<br><br>
    <em>Renueva tu plan para continuar usando el sistema.</em>
  `;

  overlay.style.display = 'block';
}


function bloquearSiVencido() {
  const data = JSON.parse(localStorage.getItem('empresaSuscripcion') || 'null');
  if (!data) return;

  // si está activo, aseguramos que el overlay esté oculto
  if (data.activo) {
    const overlay = document.getElementById('suscripcionOverlay');
    if (overlay) overlay.style.display = 'none';
    return;
  }

  // Mostrar overlay bloqueante
  mostrarAlertaSuscripcionVencida(data);

  // Deshabilitar interacciones de la página
  document.body.style.pointerEvents = 'none';

  // PERO permitir interacción solo en el overlay
  const overlay = document.getElementById('suscripcionOverlay');
  if (overlay) {
    overlay.style.pointerEvents = 'auto';
  }
}


