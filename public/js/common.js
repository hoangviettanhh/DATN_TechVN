// Cart functions
function addToCart(productId) {
    const storage = document.getElementById('storage').value;
    const color = document.getElementById('color').value;
    const quantity = document.getElementById('quantity').value;

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            storage: storage,
            color: color,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Đã thêm sản phẩm vào giỏ hàng!');
            updateCartCount(data.cartCount);
        } else {
            showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
        }
    })
    .catch(error => {
        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
    });
}

function updateCartCount(count) {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = count;
    }
}

function updateQuantity(key, newQuantity) {
    if (newQuantity < 1) return;

    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            key: key,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount(data.cartCount);
            updateTotal(data.total);
            // Cập nhật số lượng trên UI
            const quantitySpan = document.querySelector(`[data-key="${key}"] .quantity-controls span`);
            if (quantitySpan) {
                quantitySpan.textContent = newQuantity;
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Có lỗi xảy ra', 'error');
    });
}

function removeItem(key) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;

    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            key: key
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount(data.cartCount);
            updateTotal(data.total);
            // Xóa item khỏi UI
            const cartItem = document.querySelector(`[data-key="${key}"]`);
            if (cartItem) {
                cartItem.remove();
            }
            // Nếu giỏ hàng trống, reload trang
            if (data.cartCount === 0) {
                location.reload();
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Có lỗi xảy ra', 'error');
    });
}

function clearCart() {
    if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) return;

    fetch('/cart/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            location.reload();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Có lỗi xảy ra', 'error');
    });
}

function updateTotal(total) {
    const totalAmount = document.querySelector('.total-amount');
    if (totalAmount) {
        totalAmount.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
    }
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Image gallery functions
function changeImage(element) {
    const mainImage = document.getElementById("main-image");
    const images = document.querySelectorAll(".thumbnail");
    
    mainImage.src = element.src;
    images.forEach(img => img.classList.remove("active"));
    element.classList.add("active");
    currentIndex = Array.from(images).indexOf(element);
}

function prevImage() {
    const images = document.querySelectorAll(".thumbnail");
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    images[currentIndex].click();
}

function nextImage() {
    const images = document.querySelectorAll(".thumbnail");
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].click();
}

function changeQuantity(amount) {
    let input = document.getElementById('quantity');
    let currentValue = parseInt(input.value);
    let newValue = currentValue + amount;
    if (newValue >= parseInt(input.min)) {
        input.value = newValue;
    }
} 