@extends('layouts.header')

@section('content')
<div class="cart-container">
    <div class="cart-header">
        <h1>Giỏ hàng của bạn <span class="cart-count-label">({{ $cartCount ?? 0 }} sản phẩm)</span></h1>
    </div>
    
    @if(!empty($cartItems) && count($cartItems) > 0)
        <div class="cart-content">
            <div class="cart-items">
                @foreach($cartItems as $key => $item)
                    <div class="cart-item" data-product-id="{{ $item['id_product'] ?? 0 }}">
                        <div class="item-image">
                            <a href="{{ route('product.show', $item['id_product'] ?? 0) }}" class="product-image-link">
                                @if(!empty($item['image']) && file_exists(public_path('image/' . $item['image'])))
                                    <img src="{{ asset('image/' . $item['image']) }}" alt="{{ $item['name'] ?? 'Sản phẩm' }}">
                                @else
                                    <img src="{{ asset('image/default-product.png') }}" alt="Default product image">
                                @endif
                            </a>
                        </div>
                        <div class="item-details">
                            <div class="item-main-info">
                                <a href="{{ route('product.show', $item['id_product'] ?? 0) }}" class="product-title">
                                    <h3>{{ $item['name'] ?? 'Sản phẩm không xác định' }}</h3>
                                </a>
                                <div class="product-specs">
                                    <span class="spec-item">
                                        <i class="fas fa-hdd"></i>
                                        {{ $item['storage'] ?? 'Không có' }}
                                    </span>
                                    <span class="spec-item">
                                        <i class="fas fa-palette"></i>
                                        {{ $item['color'] ?? 'Không có' }}
                                    </span>
                                </div>
                            </div>
                            <div class="item-actions">
                                <div class="price-info">
                                    <p class="price">{{ number_format($item['price'] ?? 0) }}đ</p>
                                    <p class="original-price">{{ number_format(($item['price'] ?? 0) * 1.2) }}đ</p>
                                </div>
                                <div class="quantity-controls">
                                    <button class="qty-btn minus" onclick="updateQuantity({{ $item['id_product'] ?? 0 }}, 'decrease')">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" value="{{ $item['quantity'] ?? 1 }}" min="1" max="99" 
                                           onchange="updateQuantity({{ $item['id_product'] ?? 0 }}, 'set', this.value)">
                                    <button class="qty-btn plus" onclick="updateQuantity({{ $item['id_product'] ?? 0 }}, 'increase')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button class="remove-item" onclick="removeItem({{ $item['id_product'] ?? 0 }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="cart-summary">
                <div class="summary-content">
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($total ?? 0) }}đ</span>
                    </div>
                    <div class="summary-row discount">
                        <span>Giảm giá:</span>
                        <span>0đ</span>
                    </div>
                    <div class="summary-row shipping">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span class="total-amount">{{ number_format($total ?? 0) }}đ</span>
                    </div>
                    <div class="summary-actions">
                        <button class="clear-cart" onclick="clearCart()">
                            <i class="fas fa-trash"></i>
                            Xóa giỏ hàng
                        </button>
                        <button class="checkout-button">
                            <i class="fas fa-lock"></i>
                            Thanh toán ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Giỏ hàng của bạn đang trống</h2>
            <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
            <a href="{{ route('home') }}" class="continue-shopping">
                <i class="fas fa-arrow-left"></i>
                Tiếp tục mua sắm
            </a>
        </div>
    @endif
</div>

<style>
.cart-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.cart-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.cart-header h1 {
    font-size: 24px;
    color: #333;
    font-weight: 600;
}

.cart-count-label {
    color: #666;
    font-size: 16px;
    font-weight: normal;
}

.cart-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.cart-items {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.cart-item {
    display: flex;
    padding: 20px;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item:hover {
    background: #f8f9fa;
}

.item-image {
    width: 120px;
    margin-right: 20px;
}

.item-image img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.item-image img:hover {
    transform: scale(1.05);
}

.item-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
}

.item-main-info {
    flex: 1;
    padding-right: 20px;
}

.product-title {
    text-decoration: none;
}

.product-title h3 {
    color: #333;
    font-size: 16px;
    font-weight: 500;
    margin: 0 0 10px 0;
    transition: color 0.3s ease;
}

.product-title h3:hover {
    color: #d9534f;
}

.product-specs {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.spec-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    background: #f8f9fa;
    border-radius: 15px;
    font-size: 13px;
    color: #666;
}

.spec-item i {
    font-size: 12px;
    color: #999;
}

.item-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 15px;
}

.price-info {
    text-align: right;
}

.price {
    color: #d9534f;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}

.original-price {
    color: #999;
    font-size: 14px;
    text-decoration: line-through;
    margin: 5px 0 0 0;
}

.quantity-controls {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border-radius: 20px;
    padding: 5px;
}


.quantity {
    width: 40px;
    text-align: center;
    font-weight: 500;
}


.cart-summary {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    position: sticky;
    top: 20px;
}

.summary-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.summary-header h2 {
    font-size: 18px;
    color: #333;
    margin: 0;
}

.summary-content {
    padding: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    color: #666;
}

.summary-row.total {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    font-weight: 600;
    color: #333;
}

.total-amount {
    color: #d9534f;
    font-size: 20px;
}

.summary-actions {
    margin-top: 50px;
    display: flex;
    flex-direction: row;
    gap: 10px;
    justify-content: space-between;
}

.checkout-button, .clear-cart {
    width: 48%;
    padding: 12px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    font-size: 14px;
    white-space: nowrap;
    position: relative;
}

.checkout-button {
    background: #d9534f;
    color: white;
}

.checkout-button:hover {
    background: #c9302c;
    transform: translateY(-2px);
}

.clear-cart {
    background: white;
    color: #dc3545;
    border: 2px solid #dc3545;
}

.clear-cart:hover {
    background: #dc3545;
    color: white;
}

.empty-cart {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.empty-cart-icon {
    font-size: 60px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-cart h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.empty-cart p {
    color: #666;
    margin-bottom: 30px;
}

.continue-shopping {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: #d9534f;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.continue-shopping:hover {
    background: #c9302c;
    transform: translateY(-2px);
}

@media (max-width: 992px) {
    .cart-content {
        grid-template-columns: 1fr;
    }
    
    .cart-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-item {
        flex-direction: column;
    }
    
    .item-image {
        width: 100%;
        margin-right: 0;
        margin-bottom: 20px;
    }
    
    .item-details {
        flex-direction: column;
    }
    
    .item-main-info {
        padding-right: 0;
        margin-bottom: 20px;
    }
    
    .item-actions {
        align-items: flex-start;
    }
}
</style>

<script>
    function updateQuantity(productId, action, value = null) {
        let quantity = 1;
        const input = document.querySelector(`.cart-item[data-product-id="${productId}"] input[type="number"]`);
        
        if (!input) {
            console.error('Không tìm thấy input cho sản phẩm:', productId);
            return;
        }
        
        if (action === 'increase') {
            quantity = parseInt(input.value) + 1;
        } else if (action === 'decrease') {
            quantity = Math.max(1, parseInt(input.value) - 1);
        } else if (action === 'set') {
            quantity = parseInt(value);
        }

        if (quantity < 1) return;

        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật số lượng giỏ hàng trên header
                updateCartCount(data.cartCount);
                // Đợi 1.5s rồi mới reload trang
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    }

    function removeItem(productId) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng giỏ hàng trên header
                    updateCartCount(data.cartCount);
                    // Reload trang để cập nhật dữ liệu
                    setTimeout(() => {
                    location.reload();
                }, 1000);
                }
            });
        }
    }

    // Hàm cập nhật tổng tiền
    function updateTotal() {
        const items = document.querySelectorAll('.cart-item');
        let total = 0;
        items.forEach(item => {
            const price = parseFloat(item.querySelector('.price').textContent.replace(/[^0-9.-]+/g, ''));
            const quantity = parseInt(item.querySelector('input[type="number"]').value);
            total += price * quantity;
        });
        document.querySelector('.total-amount').textContent = total.toLocaleString('vi-VN') + 'đ';
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
                // Cập nhật số lượng giỏ hàng trên header
                updateCartCount(data.cartCount);
                // Đợi 1.5s rồi mới reload trang
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    }
</script>
@endsection 