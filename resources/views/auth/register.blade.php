@extends('layouts.header')

@section('content')
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h2>Đăng ký tài khoản</h2>
            <p>Tạo tài khoản mới để trải nghiệm TechVN</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Họ và tên"
                           required 
                           autocomplete="name" 
                           autofocus>
                </div>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Email"
                           required 
                           autocomplete="email">
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="Số điện thoại"
                           required 
                           autocomplete="tel">
                </div>
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input type="text" 
                           name="address" 
                           value="{{ old('address') }}" 
                           placeholder="Địa chỉ"
                           required 
                           autocomplete="street-address">
                </div>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           name="password" 
                           placeholder="Mật khẩu"
                           required 
                           autocomplete="new-password">
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           name="password_confirmation" 
                           placeholder="Xác nhận mật khẩu"
                           required 
                           autocomplete="new-password">
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-user-plus"></i>
                Đăng ký
            </button>

            <div class="social-login">
                <p>Hoặc đăng ký với</p>
                <div class="social-buttons">
                    <a href="#" class="social-button facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-button google">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
            </div>
        </form>

        <div class="auth-footer">
            <p>Đã có tài khoản? 
                <a href="{{ route('login') }}">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 20px;
}

.auth-box {
    width: 100%;
    max-width: 400px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    padding: 40px;
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h2 {
    color: #333;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
}

.auth-header p {
    color: #666;
    font-size: 16px;
}

.auth-form {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    color: #666;
}

.input-group input {
    width: 100%;
    padding: 15px 45px;
    border: 2px solid #eee;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.input-group input:focus {
    border-color: #d9534f;
    box-shadow: 0 0 0 3px rgba(217, 83, 79, 0.1);
}

.toggle-password {
    position: absolute;
    right: 15px;
    color: #666;
    cursor: pointer;
}

.error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}

.auth-button {
    position: relative;
    top: 42px;
    width: 100%;
    padding: 15px;
    background: #d9534f;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.auth-button:hover {
    background: #c9302c;
    transform: translateY(-2px);
}

.social-login {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.social-login p {
    color: #666;
    margin-bottom: 15px;
}

.social-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-button {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    transition: all 0.3s ease;
}

.social-button.facebook {
    background: #1877f2;
}

.social-button.google {
    background: #db4437;
}

.social-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.auth-footer {
    text-align: center;
    margin-top: 30px;
    color: #666;
}

.auth-footer a {
    color: #d9534f;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.auth-footer a:hover {
    color: #c9302c;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 10px;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 480px) {
    .auth-box {
        padding: 30px 20px;
    }

    .auth-header h2 {
        font-size: 24px;
    }

    .input-group input {
        padding: 12px 40px;
    }

    .social-button {
        width: 45px;
        height: 45px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for both password fields
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
});
</script>
@endsection 