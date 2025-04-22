<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TechVN</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/common.js') }}"></script>
</head>
<body>
<div class="top-bar">
    <div class="right-info">
        <p>Email hỗ trợ: <a href="mailto:techvn@gmail.com">techvn@gmail.com</a></p>
        @auth
            <div class="user-menu">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
                <div class="dropdown-menu">
                    <a href="#"><i class="fas fa-user"></i> Thông tin tài khoản</a>
                    <a href="{{ route('orders.index') }}"><i class="fas fa-shopping-bag"></i> Đơn hàng của tôi</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}">Đăng nhập</a> / <a href="{{ route('register') }}">Đăng ký</a>
        @endauth
    </div>
</div>
<header>
{{--    <aside class="sidebar">--}}
{{--        <div class="image">--}}
{{--            <img src="{{ asset('image/' . $product->image) }}" alt="{{ $product->name }}" width="200px">--}}
{{--        </div>--}}
{{--        <ul>--}}
{{--            <li><strong>Kích thước màn hình:</strong> 6.1 inch</li>--}}
{{--            <li><strong>CPU:</strong> Apple A16 Bionic</li>--}}
{{--            <li><strong>Hệ điều hành:</strong> iOS</li>--}}
{{--            <li><strong>Bộ nhớ trong:</strong> 128GB</li>--}}
{{--            <li><strong>Camera chính:</strong> 48MP - 12MP</li>--}}
{{--            <li><strong>Màu sắc:</strong> Hồng, Vàng, Xanh lá, Xanh dương</li>--}}
{{--            <li><strong>Hãng sản xuất:</strong> Apple</li>--}}
{{--            <li><strong>Tình trạng SP:</strong> Mới 100%</li>--}}
{{--        </ul>--}}
{{--    </aside>--}}
    <div class="main-header">
        <div class="logo">
            <a href="{{ route('home') }}"><img src="/image/logo.jpg" alt="TechVN"></a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Nhập tìm kiếm...">
{{--            <button><i class="fa fa-search"></i></button>--}}
        </div>
        <div class="contact-info">
            <i class="fa fa-phone"></i>
            <p>Gọi đặt hàng:<br>0836362924</p>
        </div>
        <div class="office-time">
            <i class="fa fa-clock"></i>
            <p><strong>Office Time:</strong><br>Monday to Saturday 7:00am - 10:00pm</p>
        </div>
        <div class="cart">
            <a href="{{ route('cart.view') }}">
                <i class="fa fa-shopping-cart"></i>
                <span>Giỏ hàng</span>
                <span class="cart-count">{{ \App\Models\Cart::getCartCount() }}</span>
            </a>
        </div>
    </div>
</header>
<nav>
    <ul>
        <li><a href="{{ route('home') }}">Trang chủ</a></li>
        <li><a href="#">Điện thoại</a></li>
        <li><a href="#">Laptop</a></li>
        <li><a href="#">Phụ kiện</a></li>
        <li><a href="#">Sản phẩm</a></li>
        <li><a href="#">Tin tức</a></li>
        <li><a href="#">Liên hệ</a></li>
        <li><a href="#">Giới thiệu</a></li>
    </ul>
</nav>

@yield('content')

<style>
    .cart {
        position: relative;
    }

    .cart a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
    }

    .cart i {
        font-size: 24px;
        margin-right: 5px;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        min-width: 18px;
        text-align: center;
    }

    .user-menu {
        display: inline-block;
        position: relative;
        cursor: pointer;
    }

    .user-menu i {
        margin-right: 5px;
    }

    .user-menu .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        border-radius: 4px;
        min-width: 200px;
        z-index: 1000;
    }

    .user-menu:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu a, 
    .dropdown-menu button {
        display: block;
        padding: 8px 15px;
        color: #333;
        text-decoration: none;
        width: 100%;
        text-align: left;
        border: none;
        background: none;
        cursor: pointer;
    }

    .dropdown-menu a:hover,
    .dropdown-menu button:hover {
        background: #f5f5f5;
    }

    .dropdown-menu i {
        width: 20px;
        text-align: center;
    }

    .top-bar {
        background: #f8f9fa;
        padding: 5px 20px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .right-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .right-info p {
        margin: 0;
    }

    .right-info a {
        color: #333;
        text-decoration: none;
    }

    .right-info a:hover {
        color: #007bff;
    }
</style>

<script>
// Cập nhật số lượng giỏ hàng khi có thay đổi
function updateCartCount(count) {
    document.querySelector('.cart-count').textContent = count;
}
</script>

</body>
</html>
