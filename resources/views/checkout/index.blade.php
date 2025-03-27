@extends('layouts.header')

@section('content')
<div class="cart-container">
    <div class="cart-header">
        <h1>Thanh Toán <span class="cart-count-label">({{ $cartItems->count() }} sản phẩm)</span></h1>
    </div>
    
    <div class="cart-content">
        <!-- Thông tin đơn hàng -->
        <div class="cart-items">
            <h2 class="section-title">Thông tin đơn hàng</h2>
            @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="item-image">
                        <img src="{{ asset('image/' . $item->product->image) }}" 
                             alt="{{ $item->product->name }}" 
                             class="product-image">
                    </div>
                    <div class="item-details">
                        <div class="item-main-info">
                            <h3 class="product-title">{{ $item->product->name }}</h3>
                            <div class="product-specs">
                                <span class="spec-item">
                                    <i class="fas fa-hdd"></i>
                                    {{ $item->product->storage ?? 'Không có' }}
                                </span>
                                <span class="spec-item">
                                    <i class="fas fa-palette"></i>
                                    {{ $item->product->color ?? 'Không có' }}
                                </span>
                            </div>
                        </div>
                        <div class="item-actions">
                            <div class="price-info">
                                <p class="price">{{ number_format($item->product->price) }}đ</p>
                                <p class="original-price">{{ number_format($item->product->price * 1.2) }}đ</p>
                            </div>
                            <div class="quantity-info">
                                <span>Số lượng: {{ $item->quantity }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Form thanh toán -->
        <div class="cart-summary">
            <div class="summary-content">
                <h2 class="section-title">Thông tin thanh toán</h2>
                
                <form action="{{ route('checkout.place-order') }}" method="POST" id="checkout-form">
                    @csrf
                    
                    <!-- Thông tin người nhận -->
                    <div class="form-section">
                        <h3 class="form-title">Thông tin người nhận</h3>
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" value="{{ $user->phone }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <textarea name="address" rows="3" required>{{ $user->address }}</textarea>
                        </div>
                    </div>

                    <!-- Mã giảm giá -->
                    <div class="form-section">
                        <h3 class="form-title">Mã giảm giá</h3>
                        <div class="voucher-input">
                            <div class = "">
                            <input type="text" id="voucher-code" placeholder="Nhập mã giảm giá">
                            </div>
                            <div class = "">
                            <button type="button" id="apply-voucher" class="apply-voucher-btn">
                                <i class="fas fa-check"></i>
                                Áp dụng
                            </button>
                            </div>
                        </div>
                        <input type="hidden" name="voucher_code" id="voucher-code-input">
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="form-section">
                        <h3 class="form-title">Phương thức thanh toán</h3>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label for="cod">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="vnpay" value="vnpay">
                                <label for="vnpay">
                                    <i class="fas fa-credit-card"></i>
                                    Thanh toán qua VNPay
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="summary-content">
                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Giảm giá:</span>
                            <span id="discount-amount">0đ</span>
                        </div>
                        <div class="summary-row shipping">
                            <span>Phí vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span id="total-amount">{{ number_format($subtotal) }}đ</span>
                        </div>
                    </div>

                    <!-- Nút đặt hàng -->
                    <button type="submit" class="checkout-button">
                        <i class="fas fa-lock"></i>
                        Đặt hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.section-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.form-section {
    margin-bottom: 25px;
}

.form-title {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #666;
    font-size: 14px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #d9534f;
    outline: none;
}

.form-group input[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.voucher-input {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
}

.voucher-input input {
    flex: 1;
}

.apply-voucher-btn {
    /* padding: 10px 20px; */
    background: #d9534f;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
    position: relative;
}

.apply-voucher-btn:hover {
    background: #c9302c;
}

.apply-voucher-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.checkout-button {
    width: 100%;
    padding: 15px;
    background: #d9534f;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 50px;
    position: relative;
}

.checkout-button:hover {
    background: #c9302c;
    box-shadow: 0 4px 8px rgba(217, 83, 79, 0.3);
}

.checkout-button i {
    font-size: 18px;
}
#voucher-code {
    width: 100%;
}
.cart-content{
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}
.item-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
}
.item-image {
    width: 120px;
    margin-right: 20px;
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
.summary-content {
    padding:
     20px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    color: #666;
}
#total-amount {
    color: #d9534f;
    font-size: 20px;
    font-weight: 600;
}
.summary-row.total {
    border-top: 1px solid #eee;
    font-weight: 600;
    color: #333;
}

.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.payment-method {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-method:hover {
    border-color: #d9534f;
    background-color: #fff5f5;
}

.payment-method input[type="radio"] {
    margin-right: 10px;
}

.payment-method label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    margin: 0;
}

.payment-method i {
    font-size: 20px;
    color: #d9534f;
}

.payment-method input[type="radio"]:checked + label {
    color: #d9534f;
}

.payment-method input[type="radio"]:checked ~ .payment-method {
    border-color: #d9534f;
    background-color: #fff5f5;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const voucherCode = document.getElementById('voucher-code');
    const voucherCodeInput = document.getElementById('voucher-code-input');
    const applyVoucherBtn = document.getElementById('apply-voucher');
    const discountAmount = document.getElementById('discount-amount');
    const totalAmount = document.getElementById('total-amount');
    const subtotal = {{ $subtotal }};

    applyVoucherBtn.addEventListener('click', function() {
        const code = voucherCode.value.trim();
        if (!code) return;

        // Gọi API kiểm tra mã giảm giá
        fetch(`/api/check-voucher/${code}`)
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    const discount = subtotal * (data.discount / 100);
                    discountAmount.textContent = `-${discount.toLocaleString()}đ`;
                    totalAmount.textContent = `${(subtotal - discount).toLocaleString()}đ`;
                    voucherCodeInput.value = code;
                    voucherCode.disabled = true;
                    applyVoucherBtn.disabled = true;
                    applyVoucherBtn.textContent = 'Đã áp dụng';
                } else {
                    alert('Mã giảm giá không hợp lệ!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            });
    });
});
</script>
@endpush
@endsection 