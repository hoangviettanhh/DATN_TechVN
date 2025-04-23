# Tài liệu Kỹ thuật - TechVN

## 1. Middleware Authentication & Authorization

### 1.1. Admin Middleware
**File:** `app/Http/Middleware/AdminMiddleware.php`

**Chức năng:**
- Kiểm tra xác thực và phân quyền cho trang quản trị
- Chặn truy cập trái phép vào trang admin

**Logic xử lý:**
```php
public function handle(Request $request, Closure $next)
{
    // Kiểm tra đăng nhập
    if (!Auth::check()) {
        return redirect()->route('admin.login')
            ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }

    // Kiểm tra quyền admin (id_role = 1)
    if (Auth::user()->id_role !== 1) {
        Auth::logout();
        return redirect()->route('admin.login')
            ->with('error', 'Bạn không có quyền truy cập trang này.');
    }

    return $next($request);
}
```

**Các file liên quan:**
- `routes/web.php`: Đăng ký middleware cho routes admin
- `app/Models/User.php`: Model User với các phương thức kiểm tra role
- `config/auth.php`: Cấu hình authentication

### 1.2. Luồng xử lý Authentication
1. User truy cập trang admin → Middleware kiểm tra session
2. Nếu chưa đăng nhập → Redirect tới trang login
3. Sau khi đăng nhập → Kiểm tra role
4. Nếu không phải admin → Logout và redirect về login
5. Nếu là admin → Cho phép truy cập

## 2. Quản lý Đơn hàng

### 2.1. Cấu trúc Database
**Các bảng chính:**
- `orders`: Thông tin đơn hàng
- `order_details`: Chi tiết sản phẩm trong đơn
- `order_status`: Trạng thái đơn hàng

**Relationships:**
```php
// Order Model
public function orderDetails() {
    return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
}

public function orderStatus() {
    return $this->belongsTo(OrderStatus::class, 'id_order_status', 'id_order_status');
}

// OrderDetail Model
public function order() {
    return $this->belongsTo(Order::class, 'id_order', 'id_order');
}

public function product() {
    return $this->belongsTo(Product::class, 'id_product', 'id_product');
}
```

### 2.2. Luồng xử lý đơn hàng
1. **Hiển thị danh sách:**
   - Controller: `app/Http/Controllers/Admin/OrderController.php`
   - View: `resources/views/admin/orders/list.blade.php`
   - Eager loading: `with(['user', 'orderStatus', 'orderDetails.product.productImages'])`

2. **Xem chi tiết đơn hàng:**
   - Route: `GET /admin/orders/show/{id_order}`
   - View: `resources/views/admin/orders/show.blade.php`
   - Hiển thị:
     + Thông tin đơn hàng
     + Thông tin khách hàng
     + Danh sách sản phẩm
     + Tổng tiền

3. **Cập nhật đơn hàng:**
   - Chỉ cho phép sửa địa chỉ giao hàng
   - Validation rules trong controller
   - Giữ nguyên các thông tin khác

4. **Xử lý trạng thái:**
   - Xác nhận đơn hàng: Chỉ với đơn "Success"
   - Hủy đơn hàng: Chỉ với đơn "Pending"
   - Cập nhật id_order_status tương ứng

### 2.3. Các file chính
```
app/
├── Http/Controllers/Admin/
│   └── OrderController.php
├── Models/
│   ├── Order.php
│   ├── OrderDetail.php
│   └── OrderStatus.php
└── resources/views/admin/orders/
    ├── list.blade.php
    ├── show.blade.php
    └── edit.blade.php
```

## 3. Thống kê Doanh số

### 3.1. Service Layer Pattern
**File:** `app/Services/StatisticsService.php`

**Chức năng chính:**
1. `getMonthlyRevenue`: Tính doanh số theo tháng
   - Input: năm thống kê
   - Output: mảng dữ liệu theo tháng
   - Chỉ tính đơn hàng "Success"

2. `getChartData`: Chuẩn bị dữ liệu cho biểu đồ
   - Format dữ liệu theo chuẩn Chart.js
   - Sẵn sàng cho việc mở rộng

3. `getAvailableYears`: Lấy danh sách năm có dữ liệu

### 3.2. Export Excel
**Files:**
- `app/Exports/RevenueExport.php`: Class xử lý export
- Sử dụng package `maatwebsite/excel`

**Cấu trúc dữ liệu:**
```php
[
    'year' => 2024,
    'total_revenue' => 1000000,
    'total_orders' => 50,
    'monthly_data' => [
        [
            'month' => 1,
            'month_name' => 'January',
            'total_orders' => 10,
            'revenue' => 200000
        ],
        // ... các tháng khác
    ]
]
```

### 3.3. Giao diện
**File:** `resources/views/admin/statistics/revenue.blade.php`

**Các thành phần:**
1. Filter chọn năm
2. Cards tổng quan:
   - Tổng doanh số
   - Tổng đơn hàng
3. Bảng chi tiết theo tháng
4. Nút xuất Excel

### 3.4. Luồng xử lý
1. User chọn năm → Controller nhận request
2. Service layer tính toán dữ liệu
3. Trả về view với dữ liệu đã format
4. Nếu xuất Excel → Tạo file qua RevenueExport

### 3.5. Các file liên quan
```
app/
├── Http/Controllers/Admin/
│   └── StatisticsController.php
├── Services/
│   └── StatisticsService.php
├── Exports/
│   └── RevenueExport.php
└── resources/views/admin/statistics/
    └── revenue.blade.php
```

## 4. Lưu ý quan trọng

1. **Bảo mật:**
   - Luôn kiểm tra quyền truy cập qua middleware
   - Validate dữ liệu đầu vào
   - Sử dụng CSRF token cho forms

2. **Performance:**
   - Sử dụng eager loading để tránh N+1 query
   - Index cho các cột thường xuyên query
   - Cache dữ liệu thống kê nếu cần

3. **Maintainability:**
   - Tổ chức code theo service layer pattern
   - Tách biệt logic nghiệp vụ và presentation
   - Comment đầy đủ cho các hàm phức tạp 

## 5. Biểu đồ Thống kê Dashboard

### 5.1. Service Layer Pattern
**File:** `app/Services/StatisticsService.php`

**Các phương thức chính:**
1. `getMonthlyRevenue`: Thống kê doanh số
```php
// Input: năm (nullable)
// Output: [
//     'year' => 2024,
//     'total_revenue' => 1000000,
//     'monthly_data' => [
//         ['month' => 1, 'revenue' => 100000, ...],
//         ...
//     ]
// ]
```

2. `getMonthlyCancelledOrders`: Thống kê đơn hủy
```php
// Input: năm (nullable)
// Output: [
//     'year' => 2024,
//     'total_cancelled' => 50,
//     'monthly_data' => [
//         ['month' => 1, 'total_orders' => 5, ...],
//         ...
//     ]
// ]
```

3. `getDailyPendingOrders`: Thống kê đơn chờ xử lý
```php
// Input: none (luôn lấy ngày hiện tại)
// Output: [
//     'date' => '2024-03-21',
//     'total_pending' => 10,
//     'hourly_data' => [
//         ['hour' => 0, 'total_orders' => 1, ...],
//         ...
//     ]
// ]
```

### 5.2. Xử lý Dữ liệu cho Biểu đồ

1. **Doanh số theo tháng:**
   - Query: GROUP BY MONTH(created_at)
   - Filter: orderStatus.name = 'Success'
   - Tính tổng: SUM(total_amount)
   - Format: Tiền VND

2. **Đơn hàng hủy theo tháng:**
   - Query: GROUP BY MONTH(created_at)
   - Filter: orderStatus.name = 'Cancelled'
   - Đếm số lượng: COUNT(*)
   - Format: Số nguyên

3. **Đơn hàng chờ xử lý theo giờ:**
   - Query: GROUP BY HOUR(created_at)
   - Filter: 
     + orderStatus.name = 'Pending'
     + DATE(created_at) = CURDATE()
   - Đếm số lượng: COUNT(*)
   - Format: Số nguyên

### 5.3. Cấu hình Biểu đồ (Chart.js)

1. **Biểu đồ doanh số:**
```javascript
{
    type: 'bar',
    options: {
        scales: {
            y: {
                // Format tiền VND
                callback: value => new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(value)
            }
        }
    }
}
```

2. **Biểu đồ đơn hủy:**
```javascript
{
    type: 'bar',
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1 // Chỉ hiển thị số nguyên
            }
        }
    }
}
```

3. **Biểu đồ đơn chờ xử lý:**
```javascript
{
    type: 'line',
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        }
    }
}
```

### 5.4. Luồng Cập nhật Dữ liệu

1. **Khởi tạo:**
   - Controller lấy năm từ request hoặc năm hiện tại
   - Gọi service để lấy dữ liệu cho cả 3 biểu đồ
   - Truyền dữ liệu qua view dưới dạng JSON

2. **Thay đổi năm:**
   - User chọn năm từ dropdown
   - Form submit và reload trang
   - Biểu đồ doanh số và đơn hủy cập nhật theo năm mới
   - Biểu đồ đơn chờ xử lý không thay đổi (luôn theo ngày hiện tại)

3. **Tối ưu hiệu năng:**
   - Sử dụng eager loading trong queries
   - Cache dữ liệu thống kê nếu cần
   - Giới hạn dữ liệu trả về (chỉ lấy các trường cần thiết)

### 5.5. Các file liên quan
```
app/
├── Services/
│   └── StatisticsService.php
├── Http/Controllers/Admin/
│   └── MainController.php
└── resources/views/admin/
    └── dashboard.blade.php
``` 