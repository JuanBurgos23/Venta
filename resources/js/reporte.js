
// ------- Config -------
const INVENTORY_ENDPOINT = "{{ route('inventario.reporte') }}";
const CURRENCY = new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB', minimumFractionDigits: 2 });


function buildInventoryUrl() {
  const params = new URLSearchParams();
  params.set('json', '1');
  if (window.APP?.empresaId) params.set('empresa_id', window.APP.empresaId);

  const categoria = document.querySelector('#categoryFilter')?.value || '';
  const search    = document.querySelector('#searchInput')?.value?.trim() || '';
  if (categoria) params.set('categoria_id', categoria);
  if (search)    params.set('search', search);

  return `${INVENTORY_ENDPOINT}?${params.toString()}`;
}

async function fetchInventory() {
  const url = buildInventoryUrl();
  const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
  if (!res.ok) throw new Error('No se pudo cargar el inventario');
  return res.json();
}

// ------- Helpers -------
const $ = (sel, ctx=document) => ctx.querySelector(sel);
const $$ = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));

function fmtMoney(n){ return CURRENCY.format(Number(n||0)); }
function fmtNumber(n){ return Number(n||0).toLocaleString('es-BO'); }

function computeStatus(stock, stockMin) {
  stock = Number(stock||0);
  stockMin = Number(stockMin||0);
  if (stock <= 0) return { label:'Agotado', css:'badge bg-gradient-danger' };
  if (stockMin > 0 && stock <= stockMin) return { label:'Bajo Stock', css:'badge bg-gradient-warning' };
  return { label:'Disponible', css:'badge bg-gradient-success' };
}

function rowTemplate(item, idx) {
  const codigo   = item.producto_codigo ?? '';
  const nombre   = item.producto_nombre ?? '';
  const categoria= item.categoria_nombre ?? '';
  const stock    = Number(item.total_stock ?? 0);
  const stockMin = Number(item.stock_minimo ?? 0); // si no manejas stock mínimo, dejará 0
  const cpu      = Number(item.costo_promedio_ponderado ?? 0); // "Precio Unitario" = costo promedio ponderado
  const valor    = Number(item.valor_total ?? (cpu * stock));

  const st = computeStatus(stock, stockMin);

  return `
    <tr>
      <td class="text-center">${idx}</td>
      <td>${codigo}</td>
      <td>${nombre}</td>
      <td>${categoria}</td>
      <td class="text-center">${fmtNumber(stock)}</td>
      <td class="text-center">${fmtNumber(stockMin)}</td>
      <td class="text-center"><span class="${st.css}">${st.label}</span></td>
      <td class="text-end">${fmtMoney(cpu)}</td>
      <td class="text-end">${fmtMoney(valor)}</td>
    </tr>
  `;
}

function updateTotals(tot) {
  // Si tu backend te da totales ya calculados, usa esos:
  $('#totalProducts').text(fmtNumber(tot?.total_productos ?? 0));
  $('#totalInventoryValue').text(fmtMoney(tot?.valor_total_inventario ?? 0));
  $('#lowStockProducts').text(fmtNumber(tot?.productos_bajo_o_cero ?? 0));
}

// ------- Filtros -------
function getFilterParams() {
  const categoria = $('#categoryFilter')?.value || '';
  const estado    = $('#statusFilter')?.value || '';
  const search    = $('#searchInput')?.value?.trim() || '';

  const params = new URLSearchParams();
  params.set('json', '1');               // para forzar JSON en tu controlador
  if (categoria) params.set('categoria_id', categoria);
  if (search)    params.set('search', search);

  // "estado" es un filtro de UI; lo aplicaremos en el front (Disponible/Bajo/Agotado)
  if (estado) params.set('estado_ui', estado);
  return params;
}

function applyClientStatusFilter(items, estadoUi) {
  if (!estadoUi) return items;
  return items.filter(it => {
    const st = computeStatus(it.total_stock, it.stock_minimo);
    return st.label === estadoUi;
  });
}

// ------- Carga principal -------
async function fetchInventory() {
  const params = getFilterParams();
  const url = `${INVENTORY_ENDPOINT}?${params.toString()}`;

  const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
  if (!res.ok) throw new Error('No se pudo cargar el inventario');
  const data = await res.json();

  // data.items = array agregado por producto
  const estadoUi = (new URLSearchParams(location.search)).get('estado_ui') || $('#statusFilter')?.value || '';
  const items = applyClientStatusFilter(data.items || [], estadoUi);

  renderTable(items);
  updateTotals(data.totales || calcTotalsClient(items));
}

function renderTable(items) {
  const tbody = $('#inventoryTable tbody');
  if (!tbody) return;

  if (!items.length) {
    tbody.innerHTML = `
      <tr>
        <td colspan="9" class="text-center text-muted py-4">Sin resultados para los filtros aplicados</td>
      </tr>
    `;
    return;
  }

  let html = '';
  items.forEach((it, i) => html += rowTemplate(it, i+1));
  tbody.innerHTML = html;
}

function calcTotalsClient(items) {
  // Fallback por si prefieres calcular rápido en front (si no mandas "totales" del backend)
  const total_productos = items.length;
  let valor_total_inventario = 0;
  let productos_bajo_o_cero = 0;

  items.forEach(it => {
    const stock = Number(it.total_stock || 0);
    const cpu   = Number(it.costo_promedio_ponderado || 0);
    valor_total_inventario += stock * cpu;
    if (stock <= 0) productos_bajo_o_cero++;
  });

  return {
    total_productos,
    valor_total_inventario,
    productos_bajo_o_cero
  };
}

// ------- UI events -------
function attachEvents() {
  $('#applyFilters')?.addEventListener('click', async () => {
    await fetchInventory();
  });

  // Buscar con Enter
  $('#searchInput')?.addEventListener('keydown', async (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      await fetchInventory();
    }
  });

  // Exportaciones
  $('#exportCsv')?.addEventListener('click', exportCSV);
  $('#exportExcel')?.addEventListener('click', () => window.location.href = "{{ route('inventario.reporte') }}?export=excel");
  $('#exportPdf')?.addEventListener('click',   () => window.location.href = "{{ route('inventario.reporte') }}?export=pdf");
}



// ------- Export CSV (cliente) -------
function exportCSV() {
  const rows = $$('#inventoryTable tbody tr');
  if (!rows.length) return;

  const headers = [
    '#','Código','Producto','Categoría','Stock Actual','Stock Mínimo','Estado','Precio Unitario','Valor Total'
  ];

  const data = [headers];

  rows.forEach((tr, idx) => {
    const tds = tr.querySelectorAll('td');
    if (tds.length < 9) return;
    data.push([
      tds[0].innerText.trim(),
      tds[1].innerText.trim(),
      tds[2].innerText.trim(),
      tds[3].innerText.trim(),
      tds[4].innerText.trim(),
      tds[5].innerText.trim(),
      tds[6].innerText.trim(),
      tds[7].innerText.trim(),
      tds[8].innerText.trim(),
    ]);
  });

  const csv = data.map(r => r.map(cell => `"${String(cell).replace(/"/g,'""')}"`).join(',')).join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `reporte_inventario_${new Date().toISOString().slice(0,10)}.csv`;
  a.click();
  URL.revokeObjectURL(url);
}

// ------- Init -------
document.addEventListener('DOMContentLoaded', async () => {
  attachEvents();
  await fetchInventory(); // carga inicial
});