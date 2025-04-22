@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Sửa Danh Mục</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.list') }}">Danh Mục</a></li>
                <li class="breadcrumb-item active">Sửa</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id_category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label for="name" class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       placeholder="Nhập tên danh mục">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="text-end">
                        <a href="{{ route('admin.categories.list') }}" class="btn btn-danger me-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập Nhật
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Focus vào input name khi load trang
        $('#name').focus();

        // Validate form trước khi submit
        $('form').on('submit', function(e) {
            const name = $('#name').val().trim();
            if (!name) {
                e.preventDefault();
                $('#name').addClass('is-invalid')
                    .next('.invalid-feedback').text('Vui lòng nhập tên danh mục');
                return false;
            }
            return true;
        });

        // Reset trạng thái validation khi nhập liệu
        $('#name').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        // Confirm trước khi rời trang nếu có thay đổi
        let originalValue = $('#name').val();
        $(window).on('beforeunload', function() {
            let currentValue = $('#name').val();
            if (currentValue !== originalValue) {
                return "Bạn có thay đổi chưa được lưu. Bạn có chắc muốn rời trang?";
            }
        });

        // Bỏ confirm khi submit form
        $('form').on('submit', function() {
            $(window).off('beforeunload');
        });
    });
</script>
@endsection 