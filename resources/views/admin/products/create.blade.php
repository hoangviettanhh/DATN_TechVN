@extends('layouts.header')

@section('content')
    <div class="container">
        <h1>Thêm sản phẩm mới</h1>
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" required><br>
            <label>Giá:</label>
            <input type="number" name="price" required><br>
            <label>Giá cũ:</label>
            <input type="number" name="old_price"><br>
            <label>Hình ảnh:</label>
            <input type="file" name="image" required><br>
            <label>Mô tả:</label>
            <textarea name="description"></textarea><br>
            <label>Số lượng:</label>
            <input type="number" name="quantity" value="1" min="1"><br>
            <label>Dung lượng:</label>
            <input type="text" name="storage"><br>
            <label>Màu sắc:</label>
            <input type="text" name="color"><br>
            <button type="submit">Thêm sản phẩm</button>
        </form>
    </div>
@endsection
