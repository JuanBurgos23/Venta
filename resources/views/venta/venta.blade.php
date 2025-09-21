<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>Punto de Venta - Sistema ERP</title>

        <!-- Favicon -->


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <!-- Page CSS -->
        <style>
            .product-card {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .cart-item {
                border-bottom: 1px solid #e9ecef;
                padding: 10px 0;
            }

            .category-filter {
                cursor: pointer;
                padding: 8px 15px;
                border-radius: 6px;
                margin-bottom: 5px;
                transition: all 0.2s;
            }

            .category-filter.active,
            .category-filter:hover {
                background-color: #696cff;
                color: white;
            }

            .sticky-cart {
                position: sticky;
                top: 80px;
                height: calc(100vh - 100px);
                overflow-y: auto;
            }

            .search-box {
                position: relative;
            }

            .search-results {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                z-index: 1000;
                max-height: 300px;
                overflow-y: auto;
                display: none;
            }

            .search-item {
                padding: 10px;
                border-bottom: 1px solid #eee;
                cursor: pointer;
            }

            .search-item:hover {
                background-color: #f8f9fa;
            }

            .low-stock {
                color: #ff6b6b;
                font-weight: 500;
            }

            .out-of-stock {
                color: #fa5252;
                font-weight: 600;
            }
        </style>


    </head>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header">Registrar Venta</div>
                </div>
                <div class="card-body">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Panel de productos -->
                            <div class="col-lg-8 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Productos</h5>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="search-box w-100 me-3">
                                                <input type="text" class="form-control" placeholder="Buscar producto..." id="productSearch">
                                                <div class="search-results" id="searchResults"></div>
                                            </div>
                                            <select class="form-select w-auto" id="categoryFilter">
                                                <option value="all">Todas las categorías</option>
                                                <option value="1">Electrónicos</option>
                                                <option value="2">Ropa</option>
                                                <option value="3">Hogar</option>
                                                <option value="4">Deportes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" id="productList">
                                            <!-- Los productos se cargarán dinámicamente -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel del carrito y cliente -->
                            <div class="col-lg-4">
                                <div class="card sticky-cart">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Venta Actual</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Selección de cliente -->
                                        <div class="mb-4">
                                            <label class="form-label">Cliente</label>
                                            <div class="input-group">
                                                <select class="form-select" id="clientSelect">
                                                    <option value="">Cliente general</option>
                                                    <option value="1">Juan Pérez (VIP)</option>
                                                    <option value="2">María García</option>
                                                    <option value="3">Carlos Rodríguez</option>
                                                </select>
                                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                                    <i class="icon-base bx bx-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Items del carrito -->
                                        <div class="mb-3">
                                            <h6 class="mb-3">Productos en carrito</h6>
                                            <div id="cartItems">
                                                <div class="text-center text-muted py-4">
                                                    <i class="icon-base bx bx-cart-add display-4"></i>
                                                    <p class="mt-2">No hay productos en el carrito</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Resumen de la venta -->
                                        <div class="border-top pt-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Subtotal:</span>
                                                <span id="subtotal">$0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Impuestos (18%):</span>
                                                <span id="taxes">$0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Descuento:</span>
                                                <span id="discount">$0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3 fw-bold">
                                                <span>Total:</span>
                                                <span id="total">$0.00</span>
                                            </div>

                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" id="processSale">Procesar Venta</button>
                                                <button class="btn btn-outline-secondary" id="clearCart">Limpiar Carrito</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    © <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    Sistema ERPTUXON
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                </div>
            </div>
        </div>
        <!-- Modal para agregar cliente -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="clientForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <textarea class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <select class="form-select">
                                            <option>DNI</option>
                                            <option>RUC</option>
                                            <option>Cédula</option>
                                            <option>Pasaporte</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Número de documento</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>


<!-- Custom JS para la pantalla de ventas -->
<script>
    // Datos de ejemplo (en un sistema real vendrían de una base de datos)
    const products = [{
            id: 1,
            name: "Laptop HP Pavilion",
            price: 899.99,
            category: 1,
            stock: 15,
            image: "laptop.jpg"
        },
        {
            id: 2,
            name: "Smartphone Samsung Galaxy",
            price: 499.99,
            category: 1,
            stock: 25,
            image: "phone.jpg"
        },
        {
            id: 3,
            name: "Auriculares Bluetooth",
            price: 79.99,
            category: 1,
            stock: 40,
            image: "headphones.jpg"
        },
        {
            id: 4,
            name: "Camiseta Casual",
            price: 29.99,
            category: 2,
            stock: 100,
            image: "tshirt.jpg"
        },
        {
            id: 5,
            name: "Zapatos Deportivos",
            price: 89.99,
            category: 2,
            stock: 30,
            image: "shoes.jpg"
        },
        {
            id: 6,
            name: "Silla de Oficina",
            price: 199.99,
            category: 3,
            stock: 18,
            image: "chair.jpg"
        },
        {
            id: 7,
            name: "Mesa de Centro",
            price: 149.99,
            category: 3,
            stock: 12,
            image: "table.jpg"
        },
        {
            id: 8,
            name: "Balón de Fútbol",
            price: 24.99,
            category: 4,
            stock: 50,
            image: "ball.jpg"
        },
        {
            id: 9,
            name: "Raqueta de Tenis",
            price: 69.99,
            category: 4,
            stock: 22,
            image: "racket.jpg"
        },
        {
            id: 10,
            name: "Monitor 24\"",
            price: 179.99,
            category: 1,
            stock: 5,
            image: "monitor.jpg"
        },
        {
            id: 11,
            name: "Teclado Mecánico",
            price: 89.99,
            category: 1,
            stock: 35,
            image: "keyboard.jpg"
        },
        {
            id: 12,
            name: "Jeans Modernos",
            price: 49.99,
            category: 2,
            stock: 60,
            image: "jeans.jpg"
        }
    ];

    const categories = {
        1: "Electrónicos",
        2: "Ropa",
        3: "Hogar",
        4: "Deportes"
    };

    let cart = [];
    let currentCategory = 'all';

    // Inicializar la pantalla de ventas
    $(document).ready(function() {
        loadProducts();
        setupEventListeners();
    });

    // Cargar productos en la interfaz
    function loadProducts() {
        const productList = $('#productList');
        productList.empty();

        const filteredProducts = currentCategory === 'all' ?
            products :
            products.filter(p => p.category == currentCategory);

        if (filteredProducts.length === 0) {
            productList.html('<div class="col-12 text-center py-4"><p class="text-muted">No hay productos en esta categoría</p></div>');
            return;
        }

        filteredProducts.forEach(product => {
            const stockClass = product.stock < 10 ?
                (product.stock === 0 ? 'out-of-stock' : 'low-stock') : '';

            const productCard = `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card product-card" data-id="${product.id}">
                            <img src="../../assets/img/products/${product.image}" class="card-img-top" alt="${product.name}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">${product.name}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">$${product.price.toFixed(2)}</span>
                                    <span class="${stockClass}">Stock: ${product.stock}</span>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2 add-to-cart">Agregar</button>
                            </div>
                        </div>
                    </div>
                `;
            productList.append(productCard);
        });
    }

    // Configurar event listeners
    function setupEventListeners() {
        // Filtrar por categoría
        $('#categoryFilter').change(function() {
            currentCategory = $(this).val();
            loadProducts();
        });

        // Buscar productos
        $('#productSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            if (query.length > 2) {
                const results = products.filter(p =>
                    p.name.toLowerCase().includes(query) ||
                    categories[p.category].toLowerCase().includes(query)
                );
                showSearchResults(results);
            } else {
                $('#searchResults').hide();
            }
        });

        // Agregar producto al carrito
        $(document).on('click', '.add-to-cart', function() {
            const productId = $(this).closest('.product-card').data('id');
            addToCart(productId);
        });

        // Procesar venta
        $('#processSale').click(processSale);

        // Limpiar carrito
        $('#clearCart').click(clearCart);

        // Cambiar cantidad en carrito
        $(document).on('click', '.quantity-btn', function() {
            const itemId = $(this).closest('.cart-item').data('id');
            const action = $(this).data('action');
            updateCartItemQuantity(itemId, action);
        });

        // Eliminar item del carrito
        $(document).on('click', '.remove-item', function() {
            const itemId = $(this).closest('.cart-item').data('id');
            removeFromCart(itemId);
        });
    }

    // Mostrar resultados de búsqueda
    function showSearchResults(results) {
        const resultsContainer = $('#searchResults');
        resultsContainer.empty();

        if (results.length === 0) {
            resultsContainer.html('<div class="search-item">No se encontraron productos</div>');
        } else {
            results.forEach(product => {
                const resultItem = `
                        <div class="search-item" data-id="${product.id}">
                            <div class="d-flex justify-content-between">
                                <span>${product.name}</span>
                                <span>$${product.price.toFixed(2)}</span>
                            </div>
                            <small class="text-muted">${categories[product.category]} • Stock: ${product.stock}</small>
                        </div>
                    `;
                resultsContainer.append(resultItem);
            });

            // Al hacer clic en un resultado
            $('.search-item').click(function() {
                const productId = $(this).data('id');
                addToCart(productId);
                $('#productSearch').val('');
                resultsContainer.hide();
            });
        }

        resultsContainer.show();
    }

    // Agregar producto al carrito
    function addToCart(productId) {
        const product = products.find(p => p.id === productId);

        if (!product) return;

        // Verificar stock
        if (product.stock === 0) {
            showNotification('Error', 'Producto sin stock', 'error');
            return;
        }

        // Buscar si el producto ya está en el carrito
        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            // Verificar que no exceda el stock disponible
            if (existingItem.quantity >= product.stock) {
                showNotification('Advertencia', 'No hay suficiente stock disponible', 'warning');
                return;
            }
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: 1,
                stock: product.stock
            });
        }

        updateCartDisplay();
        showNotification('Éxito', 'Producto agregado al carrito', 'success');
    }

    // Actualizar cantidad de un item en el carrito
    function updateCartItemQuantity(itemId, action) {
        const item = cart.find(item => item.id === itemId);
        const product = products.find(p => p.id === itemId);

        if (action === 'increase') {
            if (item.quantity >= product.stock) {
                showNotification('Advertencia', 'No hay suficiente stock disponible', 'warning');
                return;
            }
            item.quantity += 1;
        } else if (action === 'decrease') {
            if (item.quantity > 1) {
                item.quantity -= 1;
            } else {
                removeFromCart(itemId);
                return;
            }
        }

        updateCartDisplay();
    }

    // Eliminar producto del carrito
    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateCartDisplay();
        showNotification('Info', 'Producto eliminado del carrito', 'info');
    }

    // Actualizar visualización del carrito
    function updateCartDisplay() {
        const cartItemsContainer = $('#cartItems');

        if (cart.length === 0) {
            cartItemsContainer.html(`
                    <div class="text-center text-muted py-4">
                        <i class="icon-base bx bx-cart-add display-4"></i>
                        <p class="mt-2">No hay productos en el carrito</p>
                    </div>
                `);
        } else {
            let cartHTML = '';
            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                cartHTML += `
                        <div class="cart-item" data-id="${item.id}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">${item.name}</h6>
                                    <small class="text-muted">$${item.price.toFixed(2)} c/u</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">$${itemTotal.toFixed(2)}</span>
                                    <div class="mt-2 d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="decrease">-</button>
                                        <span class="mx-2">${item.quantity}</span>
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="increase">+</button>
                                        <button class="btn btn-sm btn-outline-danger ms-2 remove-item">
                                            <i class="icon-base bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
            });

            cartItemsContainer.html(cartHTML);
        }

        // Actualizar totales
        const taxes = subtotal * 0.18;
        const total = subtotal + taxes;

        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#taxes').text('$' + taxes.toFixed(2));
        $('#total').text('$' + total.toFixed(2));
    }

    // Procesar la venta
    function processSale() {
        if (cart.length === 0) {
            showNotification('Error', 'No hay productos en el carrito', 'error');
            return;
        }

        // Aquí iría la lógica para procesar la venta (guardar en base de datos, etc.)
        // Por ahora solo mostramos un mensaje de éxito

        const clientId = $('#clientSelect').val();
        const clientName = clientId ? $('#clientSelect option:selected').text() : 'Cliente general';

        showNotification('Venta procesada', `Venta realizada a ${clientName} por un total de ${$('#total').text()}`, 'success');

        // Limpiar carrito después de la venta
        clearCart();
    }

    // Limpiar carrito
    function clearCart() {
        cart = [];
        updateCartDisplay();
        showNotification('Info', 'Carrito vaciado', 'info');
    }

    // Mostrar notificación
    function showNotification(title, message, type) {
        // Usar la librería de notificaciones de la plantilla o una simple alerta
        alert(`${title}: ${message}`);
    }
</script>