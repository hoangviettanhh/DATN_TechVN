@extends('admin.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chỉnh Sửa Người Dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.list') }}">
                            <i class="fas fa-users"></i> Danh Sách Người Dùng
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Chỉnh Sửa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST" id="editUserForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên người dùng <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $user->name) }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', $user->email) }}"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu mới</label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password">
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation">
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    id="togglePasswordConfirm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="tel" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', $user->phone) }}"
                                               pattern="[0-9]{10}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Định dạng: 10 số</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" 
                                               class="form-control @error('address') is-invalid @enderror" 
                                               id="address" 
                                               name="address" 
                                               value="{{ old('address', $user->address) }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Vai trò <span class="text-danger">*</span></label>
                                        <select class="form-control @error('id_role') is-invalid @enderror" 
                                                id="id_role" 
                                                name="id_role" 
                                                required>
                                            @foreach(App\Models\User::getRoles() as $id => $name)
                                                <option value="{{ $id }}" {{ old('id_role', $user->id_role) == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <div class="toggle-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" 
                                                   id="status" 
                                                   name="status" 
                                                   value="1" 
                                                   {{ old('status', $user->status) ? 'checked' : '' }}>
                                            <label for="status" class="toggle-label">
                                                <span class="toggle-inner"></span>
                                                <span class="toggle-switch"></span>
                                            </label>
                                            <span class="status-text ml-2" id="statusText" style="margin-left: 10px;">
                                                {{ $user->status ? 'Đang hoạt động' : 'Ngưng hoạt động' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="{{ route('admin.users.list') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Xử lý hiển thị/ẩn mật khẩu
        $('#togglePassword').click(function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#togglePasswordConfirm').click(function() {
            const passwordInput = $('#password_confirmation');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Validate form trước khi submit
        $('#editUserForm').submit(function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#password_confirmation').val();
            const phone = $('#phone').val();

            // Kiểm tra mật khẩu khớp nếu có nhập
            if (password && password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu xác nhận không khớp!'
                });
                return false;
            }

            // Kiểm tra định dạng số điện thoại
            if (phone && !phone.match(/^[0-9]{10}$/)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Số điện thoại phải có 10 chữ số!'
                });
                return false;
            }

            // Kiểm tra độ mạnh mật khẩu nếu có nhập
            if (password && password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu phải có ít nhất 8 ký tự!'
                });
                return false;
            }

            // Kiểm tra email hợp lệ
            const email = $('#email').val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Email không hợp lệ!'
                });
                return false;
            }
        });

        // Reset validation khi người dùng nhập lại
        $('input').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });

        // Xử lý switch trạng thái
        $('#status').change(function() {
            const statusText = $('#statusText');
            if ($(this).is(':checked')) {
                statusText.text('Đang hoạt động').removeClass('text-danger').addClass('text-success');
            } else {
                statusText.text('Ngưng hoạt động').removeClass('text-success').addClass('text-danger');
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
.toggle-switch {
    display: flex;
    align-items: center;
}

.toggle-switch input[type="checkbox"] {
    display: none;
}

.toggle-label {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 15px;
    cursor: pointer;
    margin: 0;
    transition: all 0.3s ease;
}

.toggle-inner {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 26px;
    height: 26px;
    background-color: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

input[type="checkbox"]:checked + .toggle-label {
    background-color: #28a745;
}

input[type="checkbox"]:checked + .toggle-label .toggle-inner {
    transform: translateX(30px);
}

.toggle-label:active .toggle-inner {
    width: 35px;
}

.status-text {
    font-weight: 500;
    transition: all 0.3s ease;
}
</style>
@endsection 