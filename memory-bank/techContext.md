# Công nghệ Sử dụng

## Backend
- Framework: Laravel 10.x
- Database: MySQL
- ORM: Eloquent
- Authentication: Laravel Sanctum

## Frontend
- Template: AdminLTE 3
- CSS Framework: Bootstrap 5
- JavaScript: jQuery
- DataTables: Hiển thị dữ liệu dạng bảng
- SweetAlert2: Hiển thị thông báo

## Công cụ Phát triển
- IDE: Cursor
- Version Control: Git
- Package Manager: Composer
- Local Development: Laravel Sail

## Các Package Chính
```json
{
    "require": {
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.2"
    },
    "require-dev": {
        "laravel/sail": "^1.18"
    }
}
```

## Cấu hình Môi trường
- PHP 8.1+
- MySQL 8.0+
- Node.js 16+
- Composer 2.0+

## API Endpoints
- GET /admin/categories - Danh sách danh mục
- POST /admin/categories - Thêm danh mục
- PUT /admin/categories/{id} - Cập nhật danh mục
- DELETE /admin/categories/{id} - Xóa danh mục

- GET /admin/products - Danh sách sản phẩm
- POST /admin/products - Thêm sản phẩm
- PUT /admin/products/{id} - Cập nhật sản phẩm
- DELETE /admin/products/{id} - Xóa sản phẩm
- DELETE /admin/products/images/{id} - Xóa ảnh sản phẩm 