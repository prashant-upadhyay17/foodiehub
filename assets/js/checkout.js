function loadCheckoutSummary() {
    const items = JSON.parse(localStorage.getItem('foodiehub_cart') || '[]');
    const container = document.getElementById('summaryItems');
    const subtotalEl = document.getElementById('summarySubtotal');
    const gstEl = document.getElementById('summaryGst');
    const totalEl = document.getElementById('summaryTotal');
    const cartDataInput = document.getElementById('cartData');

    if (!container || !cartDataInput) return;
    container.innerHTML = '';
    let subtotal = 0;
    items.forEach(item => {
        subtotal += item.price * item.quantity;
        const card = document.createElement('div');
        card.className = 'summary-card';
        card.innerHTML = `<strong>${item.name}</strong><span>${item.quantity} x ₹${item.price}</span>`;
        container.appendChild(card);
    });
    const delivery = 50;
    const gst = Math.round(subtotal * 0.05);
    const total = subtotal + delivery + gst;

    subtotalEl.textContent = `₹${subtotal}`;
    gstEl.textContent = `₹${gst}`;
    totalEl.textContent = `₹${total}`;
    cartDataInput.value = JSON.stringify(items);
}

const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm) {
    loadCheckoutSummary();
    checkoutForm.addEventListener('submit', (event) => {
        const items = JSON.parse(localStorage.getItem('foodiehub_cart') || '[]');
        if (!items.length) {
            alert('Your cart is empty. Add items before checkout.');
            event.preventDefault();
            return;
        }
    });
}
