<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechVN</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
<body>
<div class="top-bar">
    <div class="right-info">
        <p>Email hỗ trợ: <a href="mailto:techvn@gmail.com">techvn@gmail.com</a></p>
        <a href="#">Đăng nhập</a> / <a href="#">Đăng ký</a>
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
            <i class="fa fa-shopping-cart"></i>
            <span>Giỏ hàng</span>
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

</body>
</html>
