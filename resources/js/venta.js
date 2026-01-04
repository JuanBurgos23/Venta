
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar fecha actual
            const saleDateInput = document.getElementById('sale-date');

            const today = new Date();
            const localDate = today.toISOString().split('T')[0];

            const now = new Date();
            const offset = now.getTimezoneOffset();
            const localISOTime = new Date(now.getTime() - offset * 60000)
            .toISOString()
            .slice(0, 16);

            saleDateInput.value = localISOTime;
            saleDateInput.value = localDate;

            const getCurrentTimeString = () => {
                const nowTime = new Date();
                const hours = String(nowTime.getHours()).padStart(2, '0');
                const minutes = String(nowTime.getMinutes()).padStart(2, '0');
                const seconds = String(nowTime.getSeconds()).padStart(2, '0');
                return `${hours}:${minutes}:${seconds}`;
            };

            const buildSaleDateTime = () => {
                if (!saleDateInput?.value) return null;
                return `${saleDateInput.value} ${getCurrentTimeString()}`;
            };

            const defaultImage = '/assets/img/illustrations/man-with-laptop-light.png';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            let cart = [];
            let products = [];
            let filteredProducts = [];
            let categoriesMap = {};
            let itemsToShowNew = 8;
            let itemsToShowBest = 8;

            // Añadir efecto de animación a las tarjetas de producto
            function addProductAnimation() {
                document.querySelectorAll('.product-card-pro').forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.05}s`;
                    card.classList.add('fade-in');
                });
            }

            // Función para crear tarjeta de producto profesional
            function createProductCard(product) {
                const div = document.createElement('div');
                div.className = 'product-card-pro';
                
                // Determinar estado de stock
                let stockStatus = '';
                let stockClass = '';
                
                const categoryLabel = product.categoryName || product.category || '';
                const subcategoryLabel = product.subcategoryName || product.subcategory || '';
                const brandLabel = product.brand || '';
                const hasSpecs = categoryLabel || subcategoryLabel || brandLabel;
                
                div.innerHTML = `
                    <div class="product-header-pro">
                        <span class="product-code-pro">${product.codigo || `REF-${product.id}`}</span>
                        <span class="product-status-pro ${stockClass}">${stockStatus}</span>
                    </div>
                    <div class="product-image-pro">
                        <img class="product-img-fit"
                             src="${product.image || defaultImage}" 
                             alt="${product.name || 'Producto'}"
                             onerror="this.src='${defaultImage}'">
                    </div>
                    <div class="product-info-pro">
                        <h6 class="product-title-pro">${product.name}</h6>
                        
                        ${
                            hasSpecs ? `
                                <div class="product-specs-pro">
                                    ${categoryLabel ? `
                                        <div class="spec-item-pro">
                                            <span class="spec-label-pro">Categoria:</span>
                                            <span class="spec-value-pro">${categoryLabel}</span>
                                        </div>
                                    ` : ''}
                                    ${subcategoryLabel ? `
                                        <div class="spec-item-pro">
                                            <span class="spec-label-pro">Subcategoria:</span>
                                            <span class="spec-value-pro">${subcategoryLabel}</span>
                                        </div>
                                    ` : ''}
                                    ${brandLabel ? `
                                        <div class="spec-item-pro">
                                            <span class="spec-label-pro">Marca:</span>
                                            <span class="spec-value-pro">${brandLabel}</span>
                                        </div>
                                    ` : ''}
                                </div>
                            ` : ''
                        }
                        
                        <div class="product-price-pro">
                            <div class="price-main-pro">Bs/ ${parseFloat(product.price).toFixed(2)}</div>
                            <div class="price-unit-pro">Stock: ${product.stock} unidades</div>
                        </div>
                        
                        <div class="product-action-pro">
                            <button class="btn-add-pro add-to-cart" 
                                    data-product-id="${product.id}"
                                    ${product.stock === 0 ? 'disabled' : ''}>
                                <i class="bx bx-cart-add"></i>
                                ${product.stock === 0 ? 'AGOTADO' : 'AGREGAR'}
                            </button>
                        </div>
                    </div>
                `;
                
                // Agregar evento de click
                const addButton = div.querySelector('.add-to-cart');
                if (product.stock > 0) {
                    addButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        addToCart(product);
                        
                        // Animación de confirmación
                        this.innerHTML = '<i class="bx bx-check"></i> AGREGADO';
                        this.style.background = 'var(--success-color)';
                        
                        setTimeout(() => {
                            this.innerHTML = '<i class="bx bx-cart-add"></i> AGREGAR';
                            this.style.background = '';
                        }, 1000);
                    });
                }
                
                return div;
            }
            (async () => {
                const modalApertura = new bootstrap.Modal(document.getElementById('modalAperturaCaja'));
                const modalCierre = new bootstrap.Modal(document.getElementById('modalCierreCaja'));
                let cajaActiva = null;
                const contenedorProductos = document.querySelector("#contenedorProductos");

                // Función para obtener caja activa
                async function verificarCaja() {
                    const res = await fetch('/caja/verificar');
                    const data = await res.json();
                    cajaActiva = data.activa ? data.caja : null;
                    return data;
                }

                // Mostrar modal si no hay caja activa
                const estado = await verificarCaja();
                if (!estado.activa) {
                    setDefaultDatetime('fecha_apertura');
                    modalApertura.show();
                    contenedorProductos?.classList.add("d-none");
                }

                // Configurar botón principal
                document.getElementById('btnCajaAccion').addEventListener('click', () => {
                    if (!cajaActiva) {
                        setDefaultDatetime('fecha_apertura');
                        modalApertura.show();
                    } else {
                        // Llenar datos de la caja activa en el modal de cierre
                        document.getElementById('fecha_apertura_cierre').value = cajaActiva.fecha_apertura;
                        document.getElementById('monto_inicial_cierre').value = cajaActiva.monto_inicial;
                        setDefaultDatetime('fecha_cierre');
                        modalCierre.show();
                    }
                });

                // Abrir caja
                document.getElementById('formAperturaCaja').addEventListener('submit', async e => {
                    e.preventDefault();
                    const formData = new FormData(e.target);

                    const res = await fetch('/caja/abrir', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });
                    const data = await res.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Caja abierta correctamente',
                            timer: 1500,
                            showConfirmButton: false,
                            didClose: () => {
                                location.reload();
                            }
                        });
                        modalApertura.hide();
                        contenedorProductos?.classList.remove("d-none");
                        cajaActiva = data.caja;

                    }
                });

                // Cerrar caja
                document.getElementById('formCierreCaja').addEventListener('submit', async e => {
                    e.preventDefault();
                    const formData = new FormData(e.target);

                    const res = await fetch('/caja/cerrar', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });
                    const data = await res.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Caja cerrada correctamente',
                            timer: 1500,
                            showConfirmButton: false,
                            didClose: () => {
                                location.reload();
                            }
                        });
                        modalCierre.hide();
                        cajaActiva = null;
                        contenedorProductos?.classList.add("d-none");
                    }
                });

                // Cancelar apertura sin abrir caja
                document.getElementById('btnCancelarCaja').addEventListener('click', () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No puedes realizar ventas sin abrir una caja activa',
                        text: 'Por favor abre una caja para continuar.',
                        confirmButtonText: 'Entendido'
                    });
                });

                // Función para establecer fecha/hora actual
                function setDefaultDatetime(id) {
                    const input = document.getElementById(id);
                    const now = new Date();
                    const local = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                        .toISOString().slice(0, 16);
                    input.value = local;
                }
            })();


            document.getElementById('btnCajaAccion').addEventListener('click', () => {
            });

            // Actualizar función renderProducts para usar el nuevo diseño
            window.renderProducts = function(products, container) {
                container.innerHTML = '';
                
                if (products.length === 0) {
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bx bx-package fs-1 text-muted mb-3"></i>
                                <h6 class="text-muted">No hay productos disponibles</h6>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                products.forEach(product => {
                    const productElement = createProductCard(product);
                    container.appendChild(productElement);
                });
                
                addProductAnimation();
            };          // Actualizar UI del carrito
            window.updateCartUI = function(container, subtotalEl, discountEl, totalEl, billeteInput, cambioEl) {
                if (cart.length === 0) {
                    container.innerHTML = `
                        <div class="cart-empty text-center text-muted py-4">
                            <i class="fa fa-shopping-cart fa-2x mb-3"></i>
                            <p class="mb-0">No hay productos en el carrito</p>
                        </div>
                    `;
                    return;
                }

                let subtotal = 0;
                let cartHTML = '';

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;

                    cartHTML += `
                        <div class="cart-item slide-in">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">Bs/ ${item.price.toFixed(2)} c/u</div>
                            </div>
                            <div class="cart-item-actions">
                                <button class="qty-btn remove-item" data-id="${item.id}" title="Quitar">
                                    ×
                                </button>
                                <div class="quantity-control">
                                    <button class="qty-btn decrease-quantity" data-id="${item.id}">-</button>
                                    <span class="qty-value">${item.quantity}</span>
                                    <button class="qty-btn increase-quantity" data-id="${item.id}">+</button>
                                </div>
                                <div class="cart-item-total">Bs/ ${itemTotal.toFixed(2)}</div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = cartHTML;
                subtotalEl.textContent = `Bs/ ${subtotal.toFixed(2)}`;
                
                const discount = parseFloat(discountEl.value || 0);
                const total = subtotal - discount;
                totalEl.textContent = `Bs/ ${total.toFixed(2)}`;

                // Calcular cambio
                if (billeteInput && cambioEl) {
                    const billete = parseFloat(billeteInput.value || 0);
                    const cambio = billete > 0 ? billete - total : 0;
                    cambioEl.textContent = `Bs/ ${cambio.toFixed(2)}`;
                }

                // Agregar eventos a los botones
                container.querySelectorAll('.increase-quantity').forEach(btn => {
                    btn.addEventListener('click', () => increaseQuantity(parseInt(btn.dataset.id)));
                });
                container.querySelectorAll('.decrease-quantity').forEach(btn => {
                    btn.addEventListener('click', () => decreaseQuantity(parseInt(btn.dataset.id)));
                });
                container.querySelectorAll('.remove-item').forEach(btn => {
                    btn.addEventListener('click', () => removeFromCart(parseInt(btn.dataset.id)));
                });
            };

            const sucursalSelect = document.getElementById('sucursal-select');
            const almacenSelect = document.getElementById('almacen-select');
            const productSearch = document.getElementById('product-search');
            const newProductsContainer = document.getElementById('new-products-container');
            const bestProductsContainer = document.getElementById('best-sellers-container');
            const loadMoreNewBtn = document.getElementById('load-more-new');
            const loadMoreBestBtn = document.getElementById('load-more-best');
            const clientSelect = document.getElementById('client-select');
            const clientInfoCard = document.getElementById('client-info-card');
            const subtotalEl = document.getElementById('subtotal');
            const discountEl = document.getElementById('discount-input');
            const totalEl = document.getElementById('total');
            const billeteInput = document.getElementById('billete');
            const cambioEl = document.getElementById('cambio');
            const paymentMethodSelect = document.getElementById('payment-method');
            const saleTypeSelect = document.getElementById('sale-type');
            const creditFields = document.getElementById('credit-fields');
            const dueDateInput = document.getElementById('due-date');
            const installmentsInput = document.getElementById('installments');
            const cartContainer = document.getElementById('cart-items');
            const completeSaleBtn = document.getElementById('complete-sale');
            const mobileCartCount = document.getElementById('mobile-cart-count');

            const showMessage = (text, type = 'info') => {
                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: type,
                        title: text,
                        showConfirmButton: false,
                        timer: 2200
                    });
                } else {
                    alert(text);
                }
            };

            const renderAllProducts = () => {
                const newSlice = filteredProducts.slice(0, itemsToShowNew);
                const bestSlice = filteredProducts.slice(0, itemsToShowBest);
                renderProducts(newSlice, newProductsContainer);
                renderProducts(bestSlice, bestProductsContainer);
            };

            async function loadSucursales() {
                if (!sucursalSelect) return;
                try {
                    let data = [];
                    const cache = localStorage.getItem('sucursalesEmpresa');
                    if (cache) {
                        try { data = JSON.parse(cache) || []; } catch { data = []; }
                    }
                    if (!Array.isArray(data) || !data.length) {
                        const res = await fetch('/sucursal/fetch?per_page=1000&page=1');
                        if (res.ok) {
                            const json = await res.json();
                            data = Array.isArray(json?.data) ? json.data : [];
                        }
                    }
                    sucursalSelect.innerHTML = '';
                    data.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s.id;
                        opt.textContent = s.nombre || `Sucursal ${s.id}`;
                        sucursalSelect.appendChild(opt);
                    });
                } catch (err) {
                    console.error(err);
                }
            }

            const filterProducts = term => {
                const value = term.toLowerCase();
                filteredProducts = products.filter(p =>
                    (p.name && p.name.toLowerCase().includes(value)) ||
                    (p.codigo && String(p.codigo).toLowerCase().includes(value)) ||
                    (p.category && String(p.category).toLowerCase().includes(value)) ||
                    (p.subcategory && String(p.subcategory).toLowerCase().includes(value)) ||
                    (p.brand && String(p.brand).toLowerCase().includes(value)) ||
                    (p.model && String(p.model).toLowerCase().includes(value))
                );
                itemsToShowNew = 8;
                itemsToShowBest = 8;
                renderAllProducts();
            };

            async function loadCategories() {
                try {
                    const res = await fetch('/categorias/fetch-json');
                    if (!res.ok) return;
                    const data = await res.json();
                    categoriesMap = {};
                    data.forEach(c => { categoriesMap[c.id] = c.name; });
                } catch (e) {
                    console.error(e);
                }
            }

            async function loadAlmacenes() {
                try {
                    const res = await fetch('/venta/almacenes');
                    if (!res.ok) throw new Error('No se pudieron cargar los almacenes');
                    const data = await res.json();
                    almacenSelect.innerHTML = '';
                    data.forEach(a => {
                        const opt = document.createElement('option');
                        opt.value = a.id;
                        opt.textContent = a.nombre || `Almacén ${a.id}`;
                        almacenSelect.appendChild(opt);
                    });
                    if (data.length) {
                        almacenSelect.value = data[0].id;
                        await loadProducts();
                    }
                } catch (err) {
                    console.error(err);
                    showMessage(err.message || 'Error cargando almacenes', 'error');
                }
            }

            async function loadProducts() {
                const almacenId = almacenSelect.value;
                if (!almacenId) return;
                try {
                    const res = await fetch(`/producto/venta?almacen_id=${almacenId}`);
                    if (res.status === 403) {
                        const data = await res.json();
                        showMessage(data.message || 'Debes abrir una caja activa.', 'warning');
                        return;
                    }
                    if (!res.ok) throw new Error('No se pudieron cargar los productos');
                    const data = await res.json();
                    products = data.map(p => {
                        const categoryName = p.category_name || categoriesMap[p.category] || categoriesMap[p.category_id] || p.category;
                        const subcategoryName = p.subcategory_name || p.subcategoria || '';

                        return {
                            ...p,
                            id: p.id,
                            name: p.name || p.nombre,
                            codigo: p.codigo || p.code,
                            description: p.description || p.descripcion || '',
                            price: parseFloat(p.price ?? 0),
                            stock: Number(p.stock ?? 0),
                            categoryId: p.category ?? p.category_id ?? null,
                            category: categoryName || '',
                            categoryName,
                            subcategoryId: p.subcategory ?? p.subcategory_id ?? null,
                            subcategory: subcategoryName || '',
                            subcategoryName,
                            brand: p.brand || p.marca || '',
                            model: p.model || p.modelo || '',
                            image: p.image || null,
                        };
                    });
                    filteredProducts = [...products];
                    itemsToShowNew = 8;
                    itemsToShowBest = 8;
                    renderAllProducts();
                } catch (err) {
                    console.error(err);
                    showMessage(err.message || 'Error cargando productos', 'error');
                }
            }

            async function loadClients() {
                try {
                    const res = await fetch('/clientes/fetch-json');
                    if (!res.ok) throw new Error('No se pudieron cargar los clientes');
                    const data = await res.json();
                    clientSelect.innerHTML = '<option value="">Selecciona cliente</option>';
                    data.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.id;
                        opt.textContent = [c.nombre, c.paterno].filter(Boolean).join(' ');
                        opt.dataset.client = JSON.stringify(c);
                        clientSelect.appendChild(opt);
                    });
                } catch (err) {
                    console.error(err);
                    showMessage(err.message || 'Error cargando clientes', 'error');
                }
            }

            function updateClientInfo(e) {
                const option = e.target.options[e.target.selectedIndex];
                if (!option || !option.dataset.client) {
                    clientInfoCard.classList.add('d-none');
                    return;
                }
                const data = JSON.parse(option.dataset.client);
                document.getElementById('client-name').textContent = [data.nombre, data.paterno].filter(Boolean).join(' ') || '-';
                document.getElementById('client-ci').textContent = data.ci || '-';
                document.getElementById('client-phone').textContent = data.telefono || '-';
                clientInfoCard.classList.remove('d-none');
            }

            function refreshCartUI() {
                updateCartUI(cartContainer, subtotalEl, discountEl, totalEl, billeteInput, cambioEl);
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                if (mobileCartCount) {
                    mobileCartCount.textContent = totalItems;
                    mobileCartCount.classList.toggle('d-none', totalItems === 0);
                }
            }

            function addToCart(product) {
                const existing = cart.find(i => i.id === product.id);
                if (existing) {
                    if (existing.quantity >= product.stock) {
                        showMessage('No hay suficiente stock para este producto', 'warning');
                        return;
                    }
                    existing.quantity += 1;
                } else {
                    if (product.stock <= 0) {
                        showMessage('Producto sin stock', 'warning');
                        return;
                    }
                    cart.push({ ...product, quantity: 1 });
                }
                refreshCartUI();
            }

            function increaseQuantity(productId) {
                const item = cart.find(i => i.id === productId);
                if (!item) return;
                if (item.quantity >= item.stock) {
                    showMessage('No hay suficiente stock', 'warning');
                    return;
                }
                item.quantity += 1;
                refreshCartUI();
            }

            function decreaseQuantity(productId) {
                const item = cart.find(i => i.id === productId);
                if (!item) return;
                item.quantity -= 1;
                if (item.quantity <= 0) {
                    cart = cart.filter(i => i.id !== productId);
                }
                refreshCartUI();
            }

            function removeFromCart(productId) {
                cart = cart.filter(i => i.id !== productId);
                refreshCartUI();
            }

            function toggleCreditFields(value) {
                if (!creditFields) return;
                if (value === 'credito') {
                    creditFields.style.maxHeight = '200px';
                } else {
                    creditFields.style.maxHeight = '0';
                    if (dueDateInput) dueDateInput.value = '';
                    if (installmentsInput) installmentsInput.value = '1';
                }
            }

            async function completeSale() {
                if (!sucursalSelect?.value) {
                    showMessage('Selecciona una sucursal', 'warning');
                    return;
                }
                if (!cart.length) {
                    showMessage('Agrega al menos un producto', 'warning');
                    return;
                }
                if (!clientSelect.value) {
                    showMessage('Selecciona un cliente', 'warning');
                    return;
                }
                if (!almacenSelect.value) {
                    showMessage('Selecciona un almacén', 'warning');
                    return;
                }

                const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const descuento = parseFloat(discountEl?.value || 0);
                const total = Math.max(subtotal - descuento, 0);
                const billete = parseFloat(billeteInput?.value || 0);
                const cambio = billete > 0 ? billete - total : 0;

                const payload = {
                    client_id: clientSelect.value,
                    sucursal_id: sucursalSelect?.value,
                    almacen_id: almacenSelect.value,
                    payment_method: paymentMethodSelect?.value || 'Efectivo',
                    sale_type: saleTypeSelect?.value || 'contado',
                    date: saleDateInput.value,
                    items: cart.map(i => ({ id: i.id, price: i.price, quantity: i.quantity })),
                    subtotal,
                    descuento,
                    total,
                    billete,
                    cambio,
                    due_date: dueDateInput?.value || null,
                    installments: installmentsInput?.value || null,
                };

                try {
                    const res = await fetch('/venta/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    });
                    const data = await res.json();
                    if (!res.ok || !data.success) throw new Error(data.message || 'No se pudo registrar la venta');
                    showMessage('Venta registrada correctamente', 'success');
                    cart = [];
                    if (discountEl) discountEl.value = 0;
                    if (billeteInput) billeteInput.value = '';
                    refreshCartUI();
                    if (saleTypeSelect) {
                        saleTypeSelect.value = 'contado';
                        toggleCreditFields('contado');
                    }
                    await loadProducts();
                } catch (err) {
                    console.error(err);
                    showMessage(err.message || 'Error al registrar la venta', 'error');
                }
            }

            // Eventos
            if (productSearch) {
                productSearch.addEventListener('input', e => filterProducts(e.target.value));
            }

            loadMoreNewBtn?.addEventListener('click', () => {
                itemsToShowNew += 8;
                renderAllProducts();
            });

            loadMoreBestBtn?.addEventListener('click', () => {
                itemsToShowBest += 8;
                renderAllProducts();
            });

            almacenSelect?.addEventListener('change', loadProducts);
            clientSelect?.addEventListener('change', updateClientInfo);
            discountEl?.addEventListener('input', refreshCartUI);
            billeteInput?.addEventListener('input', refreshCartUI);
            saleTypeSelect?.addEventListener('change', e => toggleCreditFields(e.target.value));
            completeSaleBtn?.addEventListener('click', e => {
                e.preventDefault();
                completeSale();
            });

            window.addToCart = addToCart;
            window.increaseQuantity = increaseQuantity;
            window.decreaseQuantity = decreaseQuantity;
            window.removeFromCart = removeFromCart;

            // Inicializar datos
            (async () => {
                await loadCategories();
                await loadSucursales();
                await loadAlmacenes();
                await loadClients();
                refreshCartUI();
            })();
        });
