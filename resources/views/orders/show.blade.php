@extends('layouts.header')

@section('title', 'Chi tiết đơn hàng #' . $order->id_order)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Chi tiết đơn hàng #{{ $order->id_order }}</h4>
                    <a href="{{ route('orders.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4 shippingInfo">
                        <div class="col-md-6 content-item">
                            <p class="content-item"><strong>Mã đơn hàng:</strong> #{{ $order->id_order }}</p>
                            <p class="content-item"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="content-item"><strong>Trạng thái:</strong> 
                                <span class="badge bg-{{ $order->orderStatus->name === 'Success' ? 'success' : 'warning' }}">
                                    {{ $order->orderStatus->name === 'Success' ? 'Thành công' : 'Đang xử lý' }}
                                </span>
                            </p>
                            <p class="content-item"><strong>Phương thức thanh toán:</strong> 
                                <span class="badge bg-info">{{ strtoupper($order->payment_method) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 content-item">
                            <p class="content-item"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                            @if($order->payment_details)
                                <h5 class="text-muted mb-3 mt-4 content-item">Chi tiết thanh toán</h5>
                                @php $paymentDetails = json_decode($order->payment_details, true) @endphp
                                @if($paymentDetails)
                                    @foreach($paymentDetails as $key => $value)
                                        <p class="content-item"><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive detailOrderItem">
                        <table class="table table-hover" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-muted text-center">Sản phẩm</th>
                                    <th class="text-muted text-center">Giá</th>
                                    <th class="text-muted text-center">Số lượng</th>
                                    <th class="text-muted text-end">Thành tiền/Sp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td class="text-center">{{ $detail->product->name }}</td>
                                    <td class="text-center">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-end">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng Tiền:</strong></td>
                                    <td class="text-end text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

.img-thumbnail {
    border-radius: 10px;
}

.btn-light {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
}

.btn-light:hover {
    background: rgba(255,255,255,0.2);
    color: white;
}

.fas {
    width: 16px;
    text-align: center;
}
.shippingInfo{
    display: flex;
    justify-content: center;
    align-items: center;
}
.content-item {
    padding : 10px
}
.text-muted {
    color: #d9534f;
    font-size: 20px;
}
.detailOrderItem{
    margin-top: 20px;
}
</style>
@endsection 