# Kiến trúc Hệ thống

## Mô hình MVC
- Model: Xử lý dữ liệu và tương tác với database
- View: Hiển thị giao diện người dùng
- Controller: Điều khiển luồng xử lý

## Cấu trúc Thư mục
```
app/
  ├── Http/
  │   └── Controllers/
  │       └── Admin/
  │           ├── CategoryController.php
  │           └── ProductController.php
  └── Models/
      ├── Category.php
      └── Product.php
resources/
  └── views/
      └── admin/
          ├── categories/
          │   ├── create.blade.php
          │   ├── edit.blade.php
          │   └── list.blade.php
          └── products/
              ├── create.blade.php
              ├── edit.blade.php
              └── list.blade.php
```

## Quy tắc Thiết kế
1. Controller
   - Mỗi controller xử lý một nhóm chức năng liên quan
   - Sử dụng dependency injection
   - Validate dữ liệu đầu vào
   - Xử lý lỗi và trả về response phù hợp

2. Model
   - Định nghĩa quan hệ giữa các bảng
   - Xử lý logic nghiệp vụ
   - Validate dữ liệu

3. View
   - Sử dụng template blade
   - Tách biệt HTML và logic
   - Sử dụng component để tái sử dụng code 