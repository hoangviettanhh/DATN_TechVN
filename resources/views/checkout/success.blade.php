@extends('layouts.header')

@section('content')
<div class="cart-container">
    <div class="cart-header">
        <h1>Đặt hàng thành công</h1>
    </div>
    
    <div class="success-content">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <div class="success-message">
            <h2>Cảm ơn bạn đã đặt hàng!</h2>
            <p>Mã đơn hàng của bạn là: <strong>#{{ $order->id_order }}</strong></p>
            <p>Chúng tôi sẽ gửi email xác nhận đơn hàng cho bạn sớm nhất có thể.</p>
        </div>

        <div class="order-details">
            <h3>Chi tiết đơn hàng</h3>
            <div class="order-info">
                <div class="info-row">
                    <span>Trạng thái:</span>
                    <span class="status-{{ strtolower($order->orderStatus->name) }}">
                        {{ $order->orderStatus->name }}
                    </span>
                </div>
                <div class="info-row">
                    <span>Phương thức thanh toán:</span>
                    <span>{{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán qua VNPay' }}</span>
                </div>
                <div class="info-row">
                    <span>Địa chỉ giao hàng:</span>
                    <span>{{ $order->address }}</span>
                </div>
                <div class="info-row">
                    <span>Tổng tiền:</span>
                    <span>{{ number_format($order->total_amount) }}đ</span>
                </div>
            </div>

            <div class="order-items">
                <h3>Sản phẩm đã đặt</h3>
                @foreach($order->orderDetails as $detail)
                <div class="order-item">
                    <img src="{{ asset('image/' . $detail->product->image) }}" 
                         alt="{{ $detail->product->name }}" 
                         class="product-image">
                    <div class="item-info">
                        <h4>{{ $detail->product->name }}</h4>
                        <p>Số lượng: {{ $detail->quantity }}</p>
                        <p>Giá: {{ number_format($detail->price) }}đ</p>
                        <p>Tổng: {{ number_format($detail->price * $detail->quantity) }}đ</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('home') }}" class="continue-shopping">
                <i class="fas fa-shopping-cart"></i>
                Tiếp tục mua sắm
            </a>
            <a href="#" class="track-order">
                <i class="fas fa-truck"></i>
                Theo dõi đơn hàng
            </a>
        </div>
    </div>
</div>

<style>
.success-content {
    background: white;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
}

.success-icon {
    font-size: 80px;
    color: #28a745;
    margin-bottom: 20px;
}

.success-message {
    margin-bottom: 30px;
}

.success-message h2 {
    color: #333;
    margin-bottom: 10px;
}

.success-message p {
    color: #666;
    margin-bottom: 5px;
}

.order-details {
    text-align: left;
    margin-bottom: 30px;
}

.order-details h3 {
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.order-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #666;
}

.info-row:last-child {
    margin-bottom: 0;
    font-weight: bold;
    color: #333;
}

.status-pending { color: #ffc107; }
.status-success { color: #28a745; }
.status-processing { color: #17a2b8; }
.status-shipped { color: #6f42c1; }
.status-delivered { color: #28a745; }
.status-cancelled { color: #dc3545; }

.order-items {
    margin-top: 20px;
}

.order-item {
    display: flex;
    gap: 20px;
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item .product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}

.item-info {
    flex: 1;
}

.item-info h4 {
    margin: 0 0 10px 0;
    color: #333;
}

.item-info p {
    margin: 5px 0;
    color: #666;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
}

.action-buttons a {
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.continue-shopping {
    background: #d9534f;
    color: white;
}

.continue-shopping:hover {
    background: #c9302c;
    transform: translateY(-2px);
}

.track-order {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
}

.track-order:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}
</style>
@endsection 