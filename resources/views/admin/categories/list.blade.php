@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Danh Sách Danh Mục</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Danh Sách Danh Mục</li>
            </ul>
        </div>
        <div class="col-auto text-end float-end ms-auto">
            <a href="{{ route('admin.categories.add') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Danh Mục
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Trạng Thái</th>
                        <th>Số Sản Phẩm</th>
                        <th class="text-end">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->status == 1)
                                <span class="badge bg-success text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                    <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                                </span>
                            @else
                                <span class="badge bg-danger text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                    <i class="fas fa-ban me-1"></i>Ngưng hoạt động
                                </span>
                            @endif
                        </td>
                        <td>{{ $category->products->count() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category->id_category) }}" 
                               class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($category->status == 1)
                                <button type="button" 
                                        class="btn btn-sm btn-warning deactivate-category me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deactivateModal"
                                        data-id="{{ $category->id_category }}"
                                        data-name="{{ $category->name }}">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @else
                                <button type="button" 
                                        class="btn btn-sm btn-success activate-category me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#activateModal"
                                        data-id="{{ $category->id_category }}"
                                        data-name="{{ $category->name }}">
                                    <i class="fas fa-unlock"></i>
                                </button>
                            @endif
                            <button type="button" 
                                    class="btn btn-sm btn-danger delete-category"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $category->id_category }}"
                                    data-name="{{ $category->name }}"
                                    data-products="{{ $category->products->count() }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                <p>Bạn có chắc chắn muốn xóa danh mục <strong id="categoryName"></strong>?</p>
                <p id="productWarning" class="text-danger d-none">
                    <i class="fas fa-exclamation-triangle"></i>
                    Danh mục này đang có <strong id="productCount"></strong> sản phẩm. 
                    Việc xóa danh mục sẽ xoá toàn bộ sản phẩm thuộc danh mục và hình ảnh liên quan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xác Nhận Xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác Nhận Vô Hiệu Hóa -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="deactivateModalLabel">Xác Nhận Vô Hiệu Hóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn vô hiệu hóa danh mục <strong id="deactivateCategoryName"></strong>?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Lưu ý: Danh mục sẽ không hiển thị cho người dùng sau khi vô hiệu hóa!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="button" class="btn btn-warning" id="confirmDeactivate">
                    <i class="fas fa-lock"></i> Xác nhận vô hiệu hóa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác Nhận Kích Hoạt -->
<div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="activateModalLabel">Xác Nhận Kích Hoạt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn kích hoạt danh mục <strong id="activateCategoryName"></strong>?</p>
                <p class="text-success">
                    <i class="fas fa-check-circle"></i>
                    Danh mục sẽ được hiển thị lại cho người dùng sau khi kích hoạt!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="button" class="btn btn-success" id="confirmActivate">
                    <i class="fas fa-unlock"></i> Xác nhận kích hoạt
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tự động ẩn alert sau 3 giây
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);

        // Xử lý modal xóa
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const products = button.getAttribute('data-products');

                const categoryNameElement = deleteModal.querySelector('#categoryName');
                const productWarningElement = deleteModal.querySelector('#productWarning');
                const productCountElement = deleteModal.querySelector('#productCount');
                const deleteForm = deleteModal.querySelector('#deleteForm');

                if (categoryNameElement) categoryNameElement.textContent = name;
                if (deleteForm) deleteForm.action = `/admin/categories/destroy/${id}`;

                if (products > 0) {
                    if (productCountElement) productCountElement.textContent = products;
                    if (productWarningElement) productWarningElement.classList.remove('d-none');
                } else {
                    if (productWarningElement) productWarningElement.classList.add('d-none');
                }
            });
        }

        // Xử lý modal vô hiệu hóa
        let categoryIdToDeactivate = null;
        const deactivateModal = document.getElementById('deactivateModal');
        if (deactivateModal) {
            deactivateModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                categoryIdToDeactivate = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                deactivateModal.querySelector('#deactivateCategoryName').textContent = name;
            });
        }

        // Xử lý modal kích hoạt
        let categoryIdToActivate = null;
        const activateModal = document.getElementById('activateModal');
        if (activateModal) {
            activateModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                categoryIdToActivate = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                activateModal.querySelector('#activateCategoryName').textContent = name;
            });
        }

        // Xử lý sự kiện vô hiệu hóa
        document.getElementById('confirmDeactivate').addEventListener('click', function() {
            if (categoryIdToDeactivate) {
                $.ajax({
                    url: `/admin/categories/deactivate/${categoryIdToDeactivate}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deactivateModal').modal('hide');
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
                        $('#deactivateModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra'
                        });
                    }
                });
            }
        });

        // Xử lý sự kiện kích hoạt
        document.getElementById('confirmActivate').addEventListener('click', function() {
            if (categoryIdToActivate) {
                $.ajax({
                    url: `/admin/categories/activate/${categoryIdToActivate}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#activateModal').modal('hide');
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
                        $('#activateModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra'
                        });
                    }
                });
            }
        });

        // Thêm hiệu ứng hover cho các nút
        const actionButtons = document.querySelectorAll('.delete-category, .deactivate-category, .activate-category');
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.querySelector('i').classList.add('fa-shake');
            });
            button.addEventListener('mouseleave', function() {
                this.querySelector('i').classList.remove('fa-shake');
            });
        });
    });
</script>
@endsection 