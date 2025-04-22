@extends('admin.main')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Sửa Sản Phẩm</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.list') }}">Danh Sách Sản Phẩm</a></li>
                <li class="breadcrumb-item active">Sửa Sản Phẩm</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông Tin Sản Phẩm</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Danh mục <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_category') is-invalid @enderror" 
                                        name="id_category" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id_category }}" 
                                                {{ old('id_category', $product->id_category) == $category->id_category ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Giá <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Giá cũ</label>
                                <input type="number" class="form-control @error('old_price') is-invalid @enderror" 
                                       name="old_price" value="{{ old('old_price', $product->old_price) }}" min="0">
                                @error('old_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Số lượng <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bộ nhớ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('storage') is-invalid @enderror" 
                                       name="storage" value="{{ old('storage', $product->storage) }}" required>
                                @error('storage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Màu sắc <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                       name="color" value="{{ old('color', $product->color) }}" required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh hiện tại</label>
                        <div class="row">
                            @foreach($product->images as $image)
                            <div class="col-md-2 mb-3">
                                <div class="position-relative">
                                    <img src="{{ asset('image/' . $image->image) }}" 
                                         alt="Product Image" 
                                         class="img-thumbnail">
                                    <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image"
                                            data-id="{{ $image->id_product_image }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Thêm hình ảnh mới</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               name="image" accept="image/*">
                        <small class="form-text text-muted">
                            Chọn 1 ảnh để thêm. Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB
                        </small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.products.list') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load jQuery trước -->
<script>
    // Kiểm tra jQuery đã load chưa
    if (typeof jQuery == 'undefined') {
        console.error('jQuery chưa được load!');
    } else {
        console.log('jQuery version:', jQuery.fn.jquery);
    }

    // Đợi DOM load xong
    $(document).ready(function() {
        console.log('Document ready');

        // Xử lý xóa ảnh
        $(document).on('click', '.delete-image', function(e) {
            e.preventDefault();
            console.log('Delete button clicked');
            
            var imageId = $(this).data('id');
            var $imageContainer = $(this).closest('.col-md-2');
            var token = $('meta[name="csrf-token"]').attr('content');

            if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                $.ajax({
                    url: `/admin/products/images/${imageId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        console.log('Delete success:', response);
                        if (response.success) {
                            $imageContainer.fadeOut(300, function() {
                                $(this).remove();
                            });
                            alert('Xóa ảnh thành công!');
                        } else {
                            alert('Có lỗi xảy ra khi xóa ảnh: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Delete error:', error);
                        alert('Có lỗi xảy ra khi xóa ảnh');
                    }
                });
            }
        });

        // Xử lý validation
        $('form').on('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            $(this).addClass('was-validated');
        });

        // Reset validation khi người dùng nhập
        $('input, select, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@endsection 