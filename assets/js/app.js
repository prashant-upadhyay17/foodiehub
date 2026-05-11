const themeToggle = document.getElementById('themeToggle');
const body = document.body;
const storedTheme = localStorage.getItem('foodiehub-theme');

if (storedTheme) {
    body.classList.remove('theme-light', 'theme-dark');
    body.classList.add(storedTheme);
    if (themeToggle) themeToggle.textContent = storedTheme === 'theme-dark' ? '☀️' : '🌙';
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const isDark = body.classList.contains('theme-dark');
        const next = isDark ? 'theme-light' : 'theme-dark';
        body.classList.remove('theme-light', 'theme-dark');
        body.classList.add(next);
        themeToggle.textContent = next === 'theme-dark' ? '☀️' : '🌙';
        localStorage.setItem('foodiehub-theme', next);
    });
}

// Search Functionality
const searchBtn = document.querySelector('.hero-search-card .button');
const searchInput = document.querySelector('.hero-search-card input');
if (searchBtn && searchInput) {
    searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query) window.location.href = `restaurants.php?search=${encodeURIComponent(query)}`;
    });
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') searchBtn.click();
    });
}

// Explore Buttons
document.querySelectorAll('.category-card').forEach(card => {
    card.style.cursor = 'pointer';
    card.addEventListener('click', () => {
        window.location.href = 'menu.php';
    });
});

document.querySelectorAll('.add-cart').forEach(button => {
    button.addEventListener('click', (e) => {
        e.stopPropagation();
        const item = JSON.parse(button.dataset.food);
        const stored = JSON.parse(localStorage.getItem('foodiehub_cart') || '[]');
        const exists = stored.find(i => i.id === item.id);
        if (exists) {
            exists.quantity += 1;
        } else {
            stored.push({ ...item, quantity: 1 });
        }
        localStorage.setItem('foodiehub_cart', JSON.stringify(stored));
        const originalText = button.textContent;
        button.textContent = 'Added';
        button.classList.add('button-success');
        setTimeout(() => { 
            button.textContent = originalText; 
            button.classList.remove('button-success');
        }, 1200);
    });
});

document.querySelectorAll('.wishlist').forEach(icon => {
    icon.addEventListener('click', (e) => {
        e.stopPropagation();
        icon.classList.toggle('active');
        icon.style.color = icon.classList.contains('active') ? '#ff4d4d' : 'inherit';
    });
});

