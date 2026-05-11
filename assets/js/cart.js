function renderCart() {
    const cartItems = JSON.parse(localStorage.getItem('foodiehub_cart') || '[]');
    const container = document.getElementById('cartItems');
    const subtotalEl = document.getElementById('cartSubtotal');
    const deliveryEl = document.getElementById('cartDelivery');
    const gstEl = document.getElementById('cartGst');
    const totalEl = document.getElementById('cartTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');

    if (!container) return;
    container.innerHTML = '';
    if (!cartItems.length) {
        container.innerHTML = '<div class="empty-state"><h3>Your cart is empty</h3><p>Add items from the menu to see them here.</p></div>';
        checkoutBtn.classList.add('button-secondary');
        checkoutBtn.textContent = 'Cart is empty';
        checkoutBtn.href = 'menu.php';
        subtotalEl.textContent = '₹0';
        gstEl.textContent = '₹0';
        totalEl.textContent = '₹0';
        return;
    }

    let subtotal = 0;
    cartItems.forEach(item => {
        subtotal += item.price * item.quantity;
        const row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML = `
            <img src="${item.image}" alt="${item.name}" />
            <div>
                <h3>${item.name}</h3>
                <p>₹${item.price} x ${item.quantity}</p>
                <div class="quantity-input">
                    <button data-action="decrease" data-id="${item.id}">-</button>
                    <span>${item.quantity}</span>
                    <button data-action="increase" data-id="${item.id}">+</button>
                </div>
            </div>
            <button class="button button-tertiary" data-action="remove" data-id="${item.id}">Remove</button>
        `;
        container.appendChild(row);
    });

    const delivery = 50;
    const gst = Math.round(subtotal * 0.05);
    const total = subtotal + delivery + gst;
    subtotalEl.textContent = `₹${subtotal}`;
    deliveryEl.textContent = `₹${delivery}`;
    gstEl.textContent = `₹${gst}`;
    totalEl.textContent = `₹${total}`;
    checkoutBtn.href = 'checkout.php';
    checkoutBtn.classList.remove('button-secondary');
    checkoutBtn.textContent = 'Proceed to checkout';
}

function updateCart(action, id) {
    const cartItems = JSON.parse(localStorage.getItem('foodiehub_cart') || '[]');
    const item = cartItems.find(i => i.id === parseInt(id, 10));
    if (!item) return;

    if (action === 'increase') item.quantity += 1;
    if (action === 'decrease') item.quantity = Math.max(1, item.quantity - 1);
    if (action === 'remove') {
        const idx = cartItems.findIndex(i => i.id === item.id);
        if (idx > -1) cartItems.splice(idx, 1);
    }

    localStorage.setItem('foodiehub_cart', JSON.stringify(cartItems));
    renderCart();
}

const cartItemsContainer = document.getElementById('cartItems');
if (cartItemsContainer) {
    renderCart();
    cartItemsContainer.addEventListener('click', event => {
        const button = event.target.closest('button');
        if (!button) return;
        const action = button.dataset.action;
        const id = button.dataset.id;
        if (action && id) updateCart(action, id);
    });
}
