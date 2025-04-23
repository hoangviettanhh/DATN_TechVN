@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h4 class="page-title">Chi tiết đơn hàng #{{ $order->id_order }}</h4>
            <div class="breadcrumb">
                <span class="me-2"><i class="fas fa-home"></i></span>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.orders.list') }}" class="text-decoration-none">Đơn hàng</a>
                <span class="mx-2">/</span>
                <span>Chi tiết</span>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.orders.edit', $order->id_order) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.orders.list') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Thông tin đơn hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Mã đơn hàng:</label>
                        <div>#{{ $order->id_order }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ngày đặt:</label>
                        <div>{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Trạng thái:</label>
                        <div>
                            <span class="badge rounded-pill 
                                @if($order->orderStatus->name == 'Success') bg-success
                                @elseif($order->orderStatus->name == 'Pending') bg-warning
                                @elseif($order->orderStatus->name == 'Cancelled') bg-danger
                                @else bg-info
                                @endif">
                                {{ $order->orderStatus->name }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Địa chỉ giao hàng:</label>
                        <div>{{ $order->address }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tổng tiền:</label>
                        <div class="h5 text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}đ</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sản phẩm trong đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 80px">Ảnh</th>
                                <th>Sản phẩm</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center" style="width: 100px">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                            <tr>
                                <td>
                                    <img src="{{ asset('image/' . ($detail->product->productImages->first() ? $detail->product->productImages->first()->image : 'no-image.jpg')) }}" 
                                         alt="{{ $detail->product->name }}"
                                         class="img-thumbnail"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $detail->product->name }}</div>
                                </td>
                                <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-end">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Thông tin khách hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ tên:</label>
                    <div>{{ $order->user->name }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <div>{{ $order->user->email }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Số điện thoại:</label>
                    <div>{{ $order->user->phone }}</div>
                </div>
                <div>
                    <label class="form-label fw-bold">Địa chỉ:</label>
                    <div>{{ $order->user->address }}</div>
                </div>
            </div>
        </div>

        <!-- Thao tác đơn hàng -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Thao tác</h5>
            </div>
            <div class="card-body">
                @if($order->orderStatus->name == 'Success')
                <form action="{{ route('admin.orders.confirm', $order->id_order) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check me-2"></i>Xác nhận đơn hàng
                    </button>
                </form>
                @endif

                @if(in_array($order->orderStatus->name, ['Pending']))
                <form action="{{ route('admin.orders.cancel', $order->id_order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-times me-2"></i>Hủy đơn hàng
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 