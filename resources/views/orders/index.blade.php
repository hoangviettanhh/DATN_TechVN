@extends('layouts.header')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container py-5">
    <div class="row" style="width: 100%;">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-gradient-purple text-white">
                    <h4 class="mb-0">Danh sách đơn hàng của bạn</h4>
                </div>
                <div class="card-body p-0">
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="width: 100%;">
                                <thead>
                                    <tr class="bg-gradient-purple text-white">
                                        <th>Mã đơn hàng</th>
                                        <th>Thời gian đặt hàng</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        @foreach($order->orderDetails as $detail)
                                        <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                             <td>#{{ $order->id_order }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $detail->product->name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id_order) }}" 
                                                   class="btn btn-sm btn-link text-decoration-none">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-purple {
    /* background: linear-gradient(45deg, #4a148c, #7b1fa2); */
}

.table {
    margin-bottom: 0;
}

.table th {
    font-weight: 500;
    border: none;
    padding: 15px;
    white-space: nowrap;
}

.table td {
    padding: 15px;
    border: none;
    vertical-align: middle;
    white-space: nowrap;
}

/* .table tbody tr:hover {
    background-color: rgba(0,0,0,0.02) !important;
}

.bg-light {
    background-color: rgba(0,0,0,0.02) !important;
} */

.btn-link {
    color: #7b1fa2;
}

.btn-link:hover {
    color: #4a148c;
}

.card {
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.card-header {
    border: none;
    padding: 20px;
}

.table-responsive {
    border-radius: 0 0 10px 10px;
    overflow: hidden;
}
</style>
@endsection 