// Lọc sản phẩm theo thể loại
function filterCategory(category) {
    const products = document.querySelectorAll('.product-item');
    products.forEach(product => {
        if (product.getAttribute('data-category') === category || category === 'All') {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Lọc sản phẩm theo giá
function filterByPrice() {
    const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
    const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;

    const products = document.querySelectorAll('.product-item');
    products.forEach(product => {
        const priceText = product.querySelector('p').innerText.replace(' VND', '').replace(',', '');
        const price = parseFloat(priceText);

        if (price >= minPrice && price <= maxPrice) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}