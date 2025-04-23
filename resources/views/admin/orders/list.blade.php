@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h4 class="page-title">Quản lý đơn hàng</h4>
            <div class="breadcrumb">
                <span class="me-2"><i class="fas fa-home"></i></span>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Đơn hàng</span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="ordersTable">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Địa chỉ</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id_order }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        <td>
                            <span class="badge rounded-pill 
                                @if($order->orderStatus->name == 'Success') bg-success
                                @elseif($order->orderStatus->name == 'Pending') bg-warning
                                @elseif($order->orderStatus->name == 'Cancelled') bg-danger
                                @else bg-info
                                @endif">
                                {{ $order->orderStatus->name }}
                            </span>
                        </td>
                        <td>{{ Str::limit($order->address, 30) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.orders.show', $order->id_order) }}" 
                                   class="btn btn-sm btn-info me-2" 
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('admin.orders.edit', $order->id_order) }}" 
                                   class="btn btn-sm btn-primary me-2" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($order->orderStatus->name == 'Đã thanh toán')
                                <button type="button" 
                                        class="btn btn-sm btn-success me-2" 
                                        onclick="confirmOrder({{ $order->id_order }})"
                                        title="Xác nhận đơn hàng">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif

                                @if(in_array($order->orderStatus->name, ['Chờ thanh toán', 'Thanh toán thất bại']))
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="cancelOrder({{ $order->id_order }})"
                                        title="Hủy đơn hàng">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal xác nhận đơn hàng -->
<div class="modal fade" id="confirmOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xác nhận đơn hàng này?</p>
            </div>
            <div class="modal-footer">
                <form id="confirmOrderForm" method="POST">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal hủy đơn hàng -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này?</p>
            </div>
            <div class="modal-footer">
                <form id="cancelOrderForm" method="POST">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                    <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#ordersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
        },
        order: [[5, 'desc']], // Sắp xếp theo cột ngày tạo (index 5) giảm dần
        pageLength: 10,
        columnDefs: [
            {
                targets: 5, // Cột ngày tạo
                type: 'date-euro' // Định dạng ngày dd/mm/yyyy
            }
        ]
    });

    // Tự động ẩn alert sau 5 giây
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

function confirmOrder(orderId) {
    const modal = $('#confirmOrderModal');
    const form = $('#confirmOrderForm');
    form.attr('action', `{{ route('admin.orders.confirm', '') }}/${orderId}`);
    modal.modal('show');
}

function cancelOrder(orderId) {
    const modal = $('#cancelOrderModal');
    const form = $('#cancelOrderForm');
    form.attr('action', `{{ route('admin.orders.cancel', '') }}/${orderId}`);
    modal.modal('show');
}
</script>
@endsection 