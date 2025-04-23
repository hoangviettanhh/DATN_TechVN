@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h4 class="page-title">Chỉnh sửa đơn hàng #{{ $order->id_order }}</h4>
            <div class="breadcrumb">
                <span class="me-2"><i class="fas fa-home"></i></span>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.orders.list') }}" class="text-decoration-none">Đơn hàng</a>
                <span class="mx-2">/</span>
                <span>Chỉnh sửa</span>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.orders.update', $order->id_order) }}" method="POST">
    @csrf
    @method('PUT')
    
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
                            <label class="form-label">Mã đơn hàng</label>
                            <input type="text" class="form-control" value="#{{ $order->id_order }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ngày đặt</label>
                            <input type="text" class="form-control" value="{{ $order->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trạng thái</label>
                            <input type="text" class="form-control" value="{{ $order->orderStatus->name }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $order->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" value="{{ $order->user->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $order->user->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" value="{{ $order->user->phone }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Nút thao tác -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.orders.show', $order->id_order) }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection 