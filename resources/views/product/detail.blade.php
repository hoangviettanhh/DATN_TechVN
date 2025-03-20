@extends('layouts.header')

@section('content')
    <div class="product-container">
        <div class="product-image-container">
            <div class="product-image">
                <button class="nav-button prev-button" onclick="prevImage()">❮</button>
                <img id="main-image" src="{{ asset('image/' . $product->image) }}" alt="{{ $product->name }}">
                <button class="nav-button next-button" onclick="nextImage()">❯</button>
            </div>
            <div class="thumbnail-container">
                @foreach ($product->images as $image)
                    <img class="thumbnail {{ $loop->first ? 'active' : '' }}" src="{{ asset('image/' . $image->image) }}" onclick="changeImage(this)">
                @endforeach
            </div>
        </div>
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <p class="price">
                {{ number_format($product->price) }}đ
                <span class="old-price">{{ number_format($product->price + 7000000) }}đ</span>
            </p>
            <div class="options">
                <label for="storage">Dung lượng:</label>
                <select id="storage" name="storage">
                    <option value="128GB">128GB</option>
                    <option value="256GB">256GB</option>
                </select>
            </div>
            <div class="options">
                <label for="color">Màu sắc:</label>
                <select id="color" name="color">
                    <option value="Hồng">Hồng</option>
                    <option value="Vàng">Vàng</option>
                    <option value="Xanh lá">Xanh lá</option>
                    <option value="Xanh dương">Xanh dương</option>
                </select>
            </div>
            <div class="options">
                <label for="quantity">Số lượng:</label>
                <div class="quantity-container">
                    <button onclick="changeQuantity(-1)">−</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button onclick="changeQuantity(1)">+</button>
                </div>
            </div>
            <div class="button-container">
                <button class="buy-button">Mua ngay</button>
{{--                <button class="cart-button">+</button>--}}
            </div>
        </div>
    </div>
    <!-- Sản phẩm tương tự -->
    <div class="section-header">
        <div class="section-title">SẢN PHẨM TƯƠNG TỰ</div>
    </div>
    <div class="product-a">
        @foreach ($similarProducts as $similarProduct)
            <a href="{{ route('product.show', $similarProduct->id_product) }}" class="product-link">
                <div class="product">
                    <img src="{{ asset('image/' . $similarProduct->image) }}" alt="{{ $similarProduct->name }}">
                    <h3>{{ $similarProduct->name }}</h3><br>
                    <p class="discount-price">{{ number_format($similarProduct->price) }}đ</p>
                    <p class="original-price">{{ number_format($similarProduct->price + 1000000) }}đ</p>
                    <div class="installment-info">Không phí chuyển đổi khi trả góp 0%</div>
                    <div class="rating">
                        <span class="stars">⭐⭐⭐⭐⭐</span>
                        <span class="wishlist"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <!-- Phần mô tả sản phẩm -->
    <main>
        <section class="news-content">
            <h2>iPhone 16 Pro Max - Mở ra kỷ nguyên mới của sự hoàn hảo</h2> <br>
            <p>iPhone 16 Pro Max là biểu tượng của sự đổi mới, thể hiện đẳng cấp và sự hiện đại bậc nhất trong trong thế giới smartphone. Với thiết kế tinh xảo và công nghệ tiên tiến, chiếc điện thoại này mang đến hiệu suất vượt trội cùng trải nghiệm người dùng hoàn hảo. Dòng sản phẩm này không chỉ đáp ứng nhu cầu công việc và giải trí mà còn mở ra khả năng sáng tạo không giới hạn. Dòng máy này được trang bị camera tiên tiến với các tính năng chụp ảnh và quay video đẳng cấp, cùng với các thông tin cải tiến về bảo mật và kết nối linh hoạt.</p>
            <p>Tìm hiểu về <a href='https://clickbuy.com.vn/iphone-16-series'>iPhone 16 Pro Max</a></p> <br>
            <img src="/image/iphone-16-pro-max-1.jpg" alt="iPhone 16 Pro Max">
            <h3>Tại sao nên mua iPhone 16 Pro Max tại TechVN?</h3> <br>
            <p>TechVN đi đầu cho những sản phẩm công nghệ chất lượng, hài lòng từ chất lượng đến dịch vụ. Chúng tôi không chỉ cung cấp những thiết bị điện tử chính hãng mà còn đem đến những dịch vụ và ưu đãi đặc biệt, từ bảo hành đến hỗ trợ sau bán hàng.</p><br>
            <h4>Là đại lý ủy quyền chính hãng của Apple tại Việt Nam</h4><br>
            <p>TechVN tự hào là đại lý ủy quyền của Apple, mang đến cho khách hàng những thiết bị chất lượng cao nhất. Khi mua sắm tại đây, khách hàng hoàn toàn yên tâm rằng mọi sản phẩm từ Apple đều được đảm bảo về nguồn gốc xuất xứ và chất lượng.</p><br>
            <h4>Dịch vụ bảo hành đặc biệt chỉ có tại TechVN</h4><br>
            <img src="/image/iphone-16-plus-pro-max-9.jpg" alt="">
            <p>Chúng tôi không chỉ cung cấp bảo hành chính hãng mà còn bổ sung thêm các gói bảo hành đặc biệt. Khách hàng sẽ được tặng bảo hành rơi vỡ và vào nước trong 12 tháng, giúp bảo vệ thiết bị khỏi những sự cố không mong muốn. Hơn nữa, với gói bảo hành 1 đổi 1 trong 12 tháng, nếu máy gặp phải lỗi kỹ thuật, người mua có thể đổi máy mới nguyên seal mà không phải lo lắng về bất kỳ vấn đề nào. Chúng tôi cam kết mang đến sự bảo vệ toàn diện và dịch vụ hỗ trợ khách hàng tốt nhất có thể.</p><br>
            <h4>Vô vàn quà tặng - Ngập tràn ưu đãi</h4><br>
            <p>Mua sắm tại đây không chỉ mang lại những sản phẩm công nghệ chất lượng mà còn đi kèm với vô vàn quà tặng hấp dẫn. Khi đặt hàng, khách hàng sẽ được nhận sạc Aukey hoặc Anker 20W, giúp sạc thiết bị nhanh chóng và hiệu quả. Thêm vào đó, chúng tôi giảm giá 300.000đ cho khách hàng đã mua iPhone 15, giảm 500.000đ khi mua iPad, MacBook hoặc Apple Watch; giảm 300.000đ khi mua AirPods. Những ưu đãi này giúp người dùng tiết kiệm chi phí. Đồng thời nâng cao trải nghiệm mua sắm của khách hàng với những quà tặng giá trị và tiện ích.</p><br>
            <h4>Thu cũ đổi mới trợ giá tới 1.500.000đ đối với tất cả các khách hàng</h4><br>
            <img src="/image/iphone-16-pro-max-10.jpg" alt="">
            <p>Tại TechVN, chúng tôi hỗ trợ chương trình thu cũ đổi mới với trợ giá lên tới 1.500.000đ. Giúp người dùng tiết kiệm chi phí khi nâng cấp lên các thiết bị công nghệ mới nhất. Chỉ cần mang điện thoại cũ đến cửa hàng, chúng tôi sẽ hỗ trợ khách hàng bằng một khoản trợ giá hấp dẫn khi mua máy mới. Chúng tôi tin chắc đây sẽ là cơ hội tuyệt vời để người mua nâng cấp thiết bị của mình với chi phí vô cùng tiết kiệm.</p><br>
            <div class="review-container">
                <div class="rating-section">
                    <h2>Đánh giá & nhận xét {{ $product->name }}</h2>
                    <span class="rating-score">4.8/5</span>
                    <div class="stars">★★★★★</div>
                    <a href="#">27 đánh giá</a>
                </div>
                <div class="rating-details">
                    <div class="rating-bar"><span>5 ★</span> <div class="bar" style="width: 80%;"></div> <span>21 đánh giá</span></div>
                    <div class="rating-bar"><span>4 ★</span> <div class="bar" style="width: 20%;"></div> <span>6 đánh giá</span></div>
                    <div class="rating-bar"><span>3 ★</span> <div class="bar empty" style="width: 0%;"></div> <span>0 đánh giá</span></div>
                    <div class="rating-bar"><span>2 ★</span> <div class="bar empty" style="width: 0%;"></div> <span>0 đánh giá</span></div>
                    <div class="rating-bar"><span>1 ★</span> <div class="bar empty" style="width: 0%;"></div> <span>0 đánh giá</span></div>
                </div>
            </div>
{{--            <button class="review-button">Đánh giá ngay</button>--}}
            <div class="review-list">
{{--                <h3>Lọc theo</h3>--}}
{{--                <div class="filter-buttons">--}}
{{--                    <button class="button">Tất cả</button>--}}
{{--                    <button class="button">Có hình ảnh</button>--}}
{{--                    <button class="button">Đã mua hàng</button>--}}
{{--                </div>--}}
                <div class="review-item">
                    <div class="review-header">
                        <span>HỒ THỊ KIM NGÂN</span>
                        <span>✔ Đã mua tại TechVN</span>
                        <span>⭐️⭐️⭐️⭐️⭐️</span>
                    </div>
                    <p class="review-text">Xin hãy hủy đơn hàng giúp em, em xin cảm ơn ạ</p>
                </div>
                <div class="review-item">
                    <div class="review-header">
                        <span>Đăng Khoa</span>
                        <span>✔ Đã mua tại TechVN</span>
                        <span>⭐️⭐️⭐️⭐️⭐️</span>
                    </div>
                    <p class="review-text">Hủy đơn hàng giúp em</p>
                </div>
                <div class="review-item">
                    <div class="review-header">
                        <span>CAO THANH TRIỀU</span>
                        <span>✔ Đã mua tại TechVN</span>
                        <span>⭐️⭐️⭐️⭐️⭐️</span>
                    </div>
                    <p class="review-text">Chất lượng đúng với giá tiền</p>
                </div>
            </div>
        </section>

        <aside class="sidebar">
            <h3>Thông số kỹ thuật {{ $product->name }}</h3>
            <div class="image">
                <img src="/image/iphone-16-pro-max-1219-cycq-300x300-217855.jpg" alt="" width="200px">
            </div>
            <ul>
                <li><strong>Kích thước màn hình:</strong> 6.9 inch</li>
                <li><strong>CPU:</strong> Apple A18 Pro</li>
                <li><strong>Hệ điều hành:</strong> iOS</li>
                <li><strong>Bộ nhớ trong:</strong> 256GB</li>
                <li><strong>Camera chính:</strong> 48MP - 12MP - 12MP</li>
                <li><strong>Màu sắc:</strong> Black Titanium, White Titanium, Natural Titanium, Desert Titanium</li>
                <li><strong>Hãng sản xuất:</strong> Apple</li>
                <li><strong>Tình trạng SP:</strong> Mới 100%</li>
            </ul>
        </aside>
    </main>

    <style>
        .product-container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            flex: 1;
            text-align: center;
        }

        .product-image {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .product-image img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
        }

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50%;
        }

        .prev-button {
            left: 10px;
        }

        .next-button {
            right: 10px;
        }

        .thumbnail-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
        }

        .thumbnail.active {
            border-color: #d9534f;
        }

        .product-info {
            flex: 1;
            padding-left: 30px;
        }

        .product-info h1 {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        .product-info .price {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f; /* Màu đỏ cho giá hiện tại */
            margin-bottom: 10px;
        }

        .product-info .old-price {
            font-size: 16px;
            color: #888;
            text-decoration: line-through;
            margin-left: 10px;
        }

        .options {
            margin-bottom: 20px;
        }

        .options label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px;
        }

        .options select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 200px;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            width: fit-content;
            padding: 4px;
        }

        .quantity-container button {
            background: #f0f0f0;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-container input {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .buy-button {
            flex: 9;
            padding: 12px;
            background-color: #d9534f;
            color: white;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .buy-button:hover {
            background-color: #c9302c;
        }

        .cart-button {
            flex: 1;
            padding: 12px;
            background-color: #fff;
            color: #d9534f;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #d9534f;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
        }

        .cart-button:hover {
            background-color: #d9534f;
            color: white;
        }

        /* Sản phẩm tương tự */
        .product-a {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 1200px;
            margin: auto;
            gap: 20px;
        }

        .product-link {
            text-decoration: none;
            color: inherit;
        }

        .product {
            width: 220px;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background: #fff;
            transition: transform 0.3s ease;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }

        .product h3 {
            font-size: 16px;
            font-weight: bold;
            color: #d9534f;
            margin: 8px 0;
            text-align: center;
        }

        .product .discount-price {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            text-align: center;
        }

        .product .original-price {
            font-size: 14px;
            text-decoration: line-through;
            color: #888;
            text-align: center;
        }

        .product .installment-info {
            background: #f5f5f5;
            padding: 6px;
            border-radius: 5px;
            font-size: 12px;
            color: #333;
            margin: 5px 0;
            text-align: center;
        }

        .product .rating {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            margin-top: 5px;
        }

        .product .rating .stars {
            color: #FFD700;
        }

        .product .rating .wishlist {
            color: #d9534f;
            font-size: 16px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 15px auto;
            padding-left: 8px;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
        }

        /* Main content */
        main {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            gap: 20px;
        }

        .news-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 7;
        }

        .news-content img {
            width: 100%;
            border-radius: 8px;
        }

        .sidebar {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 3;
            max-width: 30%;
        }

        .sidebar h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .sidebar .image {
            display: flex;
            justify-content: center;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .sidebar ul li strong {
            display: inline-block;
            width: 150px;
        }

        /* Review section */
        .review-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .rating-section, .rating-details {
            flex: 1;
        }

        .rating-section {
            text-align: center;
        }

        .rating-score {
            font-size: 24px;
            font-weight: bold;
        }

        .stars {
            color: #FFD700;
            font-size: 20px;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bar {
            height: 8px;
            background: red;
            flex: 1;
            border-radius: 4px;
        }

        .bar.empty {
            background: #ddd;
        }

        .review-button {
            display: block;
            width: 300px;
            background: red;
            color: white;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 0 auto 20px;
        }

        .review-list {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-header span {
            font-weight: bold;
        }

        .review-text {
            margin-top: 5px;
        }

        .filter-buttons {
            margin-bottom: 10px;
        }

        .button {
            border-radius: 5px;
            padding: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
    </style>

{{--    <script>--}}
{{--        let images = document.querySelectorAll(".thumbnail");--}}
{{--        let mainImage = document.getElementById("main-image");--}}
{{--        let currentIndex = 0;--}}

{{--        function changeImage(element) {--}}
{{--            mainImage.src = element.src;--}}
{{--            images.forEach(img => img.classList.remove("active"));--}}
{{--            element.classList.add("active");--}}
{{--            currentIndex = Array.from(images).indexOf(element);--}}
{{--        }--}}

{{--        function prevImage() {--}}
{{--            currentIndex = (currentIndex - 1 + images.length) % images.length;--}}
{{--            images[currentIndex].click();--}}
{{--        }--}}

{{--        function nextImage() {--}}
{{--            currentIndex = (currentIndex + 1) % images.length;--}}
{{--            images[currentIndex].click();--}}
{{--        }--}}

{{--        function changeQuantity(amount) {--}}
{{--            let input = document.getElementById('quantity');--}}
{{--            let currentValue = parseInt(input.value);--}}
{{--            let newValue = currentValue + amount;--}}
{{--            if (newValue >= parseInt(input.min)) {--}}
{{--                input.value = newValue;--}}
{{--            }--}}
{{--        }--}}

{{--        document.addEventListener("DOMContentLoaded", function () {--}}
{{--            const sidebar = document.querySelector(".sidebar");--}}
{{--            const newsContent = document.querySelector(".news-content");--}}
{{--            const main = document.querySelector("main");--}}
{{--            const sidebarWrapper = document.createElement("div");--}}

{{--            main.style.display = "flex";--}}
{{--            main.style.gap = "30px";--}}
{{--            main.style.alignItems = "flex-start";--}}

{{--            newsContent.style.flex = "7";--}}
{{--            sidebarWrapper.style.flex = "3";--}}
{{--            sidebarWrapper.style.maxWidth = "30%";--}}

{{--            sidebar.parentNode.insertBefore(sidebarWrapper, sidebar);--}}
{{--            sidebarWrapper.appendChild(sidebar);--}}
{{--            sidebarWrapper.style.position = "relative";--}}
{{--            sidebarWrapper.style.width = `${sidebar.offsetWidth}px`;--}}
{{--            sidebarWrapper.style.height = `${sidebar.offsetHeight}px`;--}}

{{--            function handleSidebarScroll() {--}}
{{--                const sidebarHeight = sidebar.offsetHeight;--}}
{{--                const newsContentHeight = newsContent.offsetHeight;--}}
{{--                const mainTop = main.offsetTop;--}}
{{--                const scrollY = window.scrollY;--}}
{{--                const sidebarFixedTop = 10;--}}
{{--                const maxSidebarScroll = mainTop + newsContentHeight - sidebarHeight;--}}

{{--                if (scrollY >= mainTop - sidebarFixedTop && scrollY < maxSidebarScroll) {--}}
{{--                    sidebar.style.position = "fixed";--}}
{{--                    sidebar.style.top = `${sidebarFixedTop}px`;--}}
{{--                    sidebar.style.width = `${sidebarWrapper.offsetWidth}px`;--}}
{{--                } else if (scrollY >= maxSidebarScroll) {--}}
{{--                    sidebar.style.position = "absolute";--}}
{{--                    sidebar.style.top = (newsContentHeight - sidebarHeight) + "px";--}}
{{--                } else {--}}
{{--                    sidebar.style.position = "static";--}}
{{--                }--}}
{{--            }--}}

{{--            window.addEventListener("scroll", handleSidebarScroll);--}}
{{--            window.addEventListener("resize", handleSidebarScroll);--}}
{{--        });--}}
{{--    </script>--}}
@endsection
