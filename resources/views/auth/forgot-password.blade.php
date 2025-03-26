@extends('layouts.header')

@section('content')
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <h2>Quên mật khẩu</h2>
            <p>Nhập email của bạn để nhận link đặt lại mật khẩu</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
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
                           autocomplete="email" 
                           autofocus>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-paper-plane"></i>
                Gửi link đặt lại mật khẩu
            </button>
        </form>

        <div class="auth-footer">
            <p>Đã nhớ mật khẩu? 
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

.error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}

.auth-button {
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

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
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
}
</style>
@endsection 