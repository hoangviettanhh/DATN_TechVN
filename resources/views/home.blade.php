@extends('layouts.header')

@section('content')
    <div class="container">
        <div class="left-column">
            <ul>
                <li><i class="fas fa-mobile-alt"></i> Điện thoại, Tablet <span>›</span></li>
                <li><i class="fa fa-laptop"></i> Laptop <span>›</span></li>
                <li><i class="fa fa-headphones"></i> Âm thanh <span>›</span></li>
                <li><i class="fa fa-camera-retro"></i> Đồng hồ, Camera <span>›</span></li>
                <li><img src="icons/home.png"> Đồ gia dụng <span>›</span></li>
                <li><i class="far fa-keyboard"></i> Phụ kiện <span>›</span></li>
                <li><i class="fa fa-desktop"></i> PC, Màn hình, Máy in <span>›</span></li>
                <li><i class="fa fa-tv"></i> Tivi <span>›</span></li>
                <li><img src="icons/exchange.png"> Thu cũ đổi mới <span>›</span></li>
            </ul>
        </div>
        <div class="middle-column">
            <div class="slider">
                <button class="prev">❮</button>
                <div class="slides">
                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:690:300/q:90/plain/https://dashboard.cellphones.com.vn/storage/16-pro-max-AfterValentine.jpg" class="slide">
                    <img src="/image/banner.jpg" class="slide">
                    <img src="/image/banner2.jpg" class="slide">
                    <img src="/image/banner3.jpg" class="slide">
                </div>
                <button class="next">❯</button>
            </div>
        </div>
        <div class="right-column">
            <img src="/image/giamgia.jpg" class="ad-image">
            <img src="/image/giamgia2.jpg" class="ad-image">
        </div>
    </div>

    @if (!empty($products) && is_array($products))
        @foreach ($products as $key => $categoryGroup)
            <div class="section-header">
                <div class="section-title">
                   <?php echo $key . ' nổi bật' ?>
                </div>
                <div class="more-links">
                    <a href="#">Samsung</a>
                    <a href="#">iPhone</a>
                    <a href="#">Xiaomi</a>
                    <a href="#">Oppo</a>
                    <a href="#">Xem tất cả</a>
                </div>
            </div>
            <div class="product-container">
                @foreach ($categoryGroup as $product)
                    <div class="product">
                        <a href="{{ route('product.show', $product->id_product) }}" class="product-link">
                            <img src="{{ asset('image/' . $product->image) }}" alt="{{ $product->name }}">
                            <h3>{{ $product->name }}</h3><br>
                            <p class="discount-price">{{ number_format($product->price) }}đ</p>
                            <p class="original-price">{{ number_format($product->old_price) }}đ</p>
                            <div class="installment-info">Không phí chuyển đổi khi trả góp 0%</div>
                            <div class="rating">
                                ⭐⭐⭐⭐⭐
                                <span class="wishlist"><i class="fa fa-heart"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection

<style>
    .product-link {
        text-decoration: none;
        color: inherit;
    }
</style>
