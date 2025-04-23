<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card shadow" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="{{ asset('assets/img/login_2.jpg') }}"
                                    alt="Đăng nhập" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem; object-fit: cover;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.login.store') }}" method="POST" id="loginForm">
                                        @csrf
                                        <div class="text-center mb-4">
                                            <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                                            <h4 class="fw-bold">Đăng nhập quản trị</h4>
                                            <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                id="password" placeholder="Mật khẩu" required>
                                            <label for="password">Mật khẩu</label>
                                            <div class="position-relative"style="top:-28px">
                                                <i class="fas fa-eye position-absolute end-0 top-50 translate-middle-y me-3 text-muted" 
                                                   style="cursor: pointer;" onclick="togglePassword()"></i>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                            </button>
                                        </div>

                                        <div class="text-center">
                                            <p class="mb-0">Chưa có tài khoản? 
                                                <a href="{{ route('admin.register') }}" class="text-primary fw-bold">Đăng ký</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.fa-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Tự động ẩn thông báo sau 5 giây
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html> 