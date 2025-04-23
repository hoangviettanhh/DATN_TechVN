@extends('admin.main')

@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Danh Sách Người Dùng</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Danh Sách Người Dùng</li>
            </ul>
        </div>
        <div class="col-auto text-end float-end ms-auto">
            <a href="{{ route('admin.users.add') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Người Dùng
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            @if($user->status == 1)
                                <span class="badge bg-success text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                    <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                                </span>
                            @else
                                <span class="badge bg-danger text-white fw-bold" style="font-size: 14px; padding: 8px 12px;">
                                    <i class="fas fa-ban me-1"></i>Ngưng hoạt động
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $user->id_user) }}" 
                               class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->status == 1)
                                <button type="button" 
                                        class="btn btn-sm btn-warning deactivate-user me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deactivateModal"
                                        data-id="{{ $user->id_user }}"
                                        data-name="{{ $user->name }}">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @else
                                <button type="button" 
                                        class="btn btn-sm btn-success activate-user me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#activateModal"
                                        data-id="{{ $user->id_user }}"
                                        data-name="{{ $user->name }}">
                                    <i class="fas fa-unlock"></i>
                                </button>
                            @endif
                            <button type="button" 
                                    class="btn btn-sm btn-danger delete-user"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $user->id_user }}"
                                    data-name="{{ $user->name }}">
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
                <p>Bạn có chắc chắn muốn xóa người dùng <strong id="userName"></strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Lưu ý: Hành động này không thể hoàn tác!
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

<!-- Modal Xác Nhận Vô Hiệu Hóa -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="deactivateModalLabel">Xác Nhận Vô Hiệu Hóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn vô hiệu hóa người dùng <strong id="deactivateUserName"></strong>?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Người dùng sẽ không thể đăng nhập sau khi bị vô hiệu hóa!
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
                <p>Bạn có chắc chắn muốn kích hoạt người dùng <strong id="activateUserName"></strong>?</p>
                <p class="text-success">
                    <i class="fas fa-check-circle"></i>
                    Người dùng sẽ có thể đăng nhập lại sau khi được kích hoạt!
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
        // Khởi tạo DataTable
        $('#usersTable').DataTable({
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

        // Tự động ẩn alert sau 3 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);

        // Xử lý modal xóa
        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');

            $('#userName').text(name);
            $('#deleteForm').attr('action', `/admin/users/destroy/${id}`);
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
                    if (response.success) {
                        $('#deleteModal').modal('hide');
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
                    $('#deleteModal').modal('hide');
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: response.message || 'Có lỗi xảy ra khi xóa người dùng'
                    });
                }
            });
        });

        // Xử lý modal vô hiệu hóa
        let userIdToDeactivate = null;
        $('#deactivateModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            userIdToDeactivate = button.data('id');
            const name = button.data('name');
            $('#deactivateUserName').text(name);
        });

        // Xử lý modal kích hoạt
        let userIdToActivate = null;
        $('#activateModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            userIdToActivate = button.data('id');
            const name = button.data('name');
            $('#activateUserName').text(name);
        });

        // Xử lý sự kiện vô hiệu hóa
        $('#confirmDeactivate').click(function() {
            if (userIdToDeactivate) {
                $.ajax({
                    url: `/admin/users/deactivate/${userIdToDeactivate}`,
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
        $('#confirmActivate').click(function() {
            if (userIdToActivate) {
                $.ajax({
                    url: `/admin/users/activate/${userIdToActivate}`,
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
        const actionButtons = document.querySelectorAll('.delete-user, .deactivate-user, .activate-user');
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