@extends('admin.main')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Danh Sách Sản Phẩm</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Danh Sách Sản Phẩm</li>
            </ul>
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

<!-- Thêm div để hiển thị thông báo động -->
<div id="notification" class="alert alert-dismissible fade" role="alert" style="display: none;">
    <span id="notification-message"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.products.add') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Sản Phẩm
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <img src="{{ asset('image/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-thumbnail" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category_name }}</td>
                                <td>{{ number_format($product->price) }}đ</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    @if($product->status == 1)
                                        <span class="badge bg-success text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                            <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-danger text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                            <i class="fas fa-ban me-1"></i>Ngưng hoạt động
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.products.edit', $product->id_product) }}" 
                                           class="btn btn-sm btn-warning me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($product->status == 1)
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning deactivate-product"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deactivateModal"
                                                    data-id="{{ $product->id_product }}"
                                                    data-name="{{ $product->name }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-sm btn-success activate-product"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#activateModal"
                                                    data-id="{{ $product->id_product }}"
                                                    data-name="{{ $product->name }}">
                                                <i class="fas fa-unlock"></i>
                                            </button>
                                        @endif
                                        <button type="button" style="margin-left: 10px;" 
                                                class="btn btn-sm btn-danger delete-product"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="{{ $product->id_product }}"
                                                data-name="{{ $product->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác Nhận Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="productName"></strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Lưu ý: Hành động này sẽ xóa tất cả hình ảnh liên quan đến sản phẩm và không thể hoàn tác!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xác nhận xóa
                    </button>
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
        // Hàm hiển thị thông báo
        function showNotification(message, type) {
            const notification = $('#notification');
            const messageElement = $('#notification-message');
            
            // Xóa các class cũ
            notification.removeClass('alert-success alert-danger');
            
            // Thêm class mới dựa vào type
            notification.addClass(type === 'success' ? 'alert-success' : 'alert-danger');
            
            // Cập nhật nội dung
            messageElement.text(message);
            
            // Hiển thị thông báo
            notification.addClass('show').show();
            
            // Tự động ẩn sau 5 giây
            setTimeout(function() {
                notification.removeClass('show').hide();
            }, 5000);
        }

        // Khởi tạo DataTable
        $('#productsTable').DataTable({
            language: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Xem _MENU_ mục",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix": "",
                "sSearch": "Tìm:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Đầu",
                    "sPrevious": "Trước",
                    "sNext": "Tiếp",
                    "sLast": "Cuối"
                }
            },
            responsive: true
        });

        // Tự động ẩn alert sau 5 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Xử lý modal xóa
        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');

            $('#productName').text(name);
            $('#deleteForm').attr('action', `/admin/products/destroy/${id}`);
        });

        // Xử lý submit form xóa
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Ẩn modal
                    $('#deleteModal').modal('hide');
                    
                    if (response.success) {
                        showNotification(response.message, 'success');
                        // Reload trang sau 1 giây
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification(response.message, 'danger');
                    }
                },
                error: function(xhr) {
                    // Ẩn modal
                    $('#deleteModal').modal('hide');
                    
                    const response = xhr.responseJSON;
                    showNotification(response.message || 'Có lỗi xảy ra khi xóa sản phẩm', 'danger');
                }
            });
        });

        // Thêm hiệu ứng hover cho nút xóa
        $('.delete-product').hover(
            function() {
                $(this).find('i').addClass('fa-shake');
            },
            function() {
                $(this).find('i').removeClass('fa-shake');
            }
        );

        // Xử lý vô hiệu hóa sản phẩm
        $('.deactivate-product').click(function() {
            const id = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn vô hiệu hóa sản phẩm này?')) {
                $.ajax({
                    url: `/admin/products/deactivate/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            }
        });

        // Xử lý kích hoạt sản phẩm
        $('.activate-product').click(function() {
            const id = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn kích hoạt sản phẩm này?')) {
                $.ajax({
                    url: `/admin/products/activate/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            }
        });
    });
</script>
@endsection 