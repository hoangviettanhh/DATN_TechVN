@section('content')
    <div class="container">
        <h1 class="page-title">Quản lý sản phẩm</h1>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Nút Thêm sản phẩm -->
        <button class="btn-add" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </button>
        <button class="btn-add" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i> Thêm hình ảnh
        </button>
        <!-- Bảng danh sách sản phẩm -->
        <div class="table-wrapper">
            <table class="product-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Hình ảnh</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id_product }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category_name }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if(!empty($product->images))
                                @foreach($product->images as $image)
                                    <img src="{{ asset('image/' . $image) }}" alt="{{ $image }}" class="product-img">
                                @endforeach
                            @else
                                <span>Không có hình ảnh</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">Chưa có sản phẩm nào</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Popup (Modal) thêm sản phẩm -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm sản phẩm mới</h5>
                        <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="id_category">Danh mục</label>
                                    <select name="id_category" id="id_category" class="form-control @error('id_category') is-invalid @enderror">
                                        <option value="">Chọn danh mục</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_category')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="price">Giá</label>
                                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                    @error('price')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="old_price">Giá cũ</label>
                                    <input type="number" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price') }}">
                                    @error('old_price')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="storage">Dung lượng</label>
                                    <input type="text" name="storage" id="storage" class="form-control @error('storage') is-invalid @enderror" value="{{ old('storage') }}">
                                    @error('storage')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="color">Màu sắc</label>
                                    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color') }}">
                                    @error('color')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label for="description">Mô tả</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                    @error('quantity')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="images">Hình ảnh</label>
                                    <input type="file" name="image" id="image" class="form-control-file" multiple>
                                    @error('images.*')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-close" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn-submit">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm hình ảnh cho sản phẩm</h5>
                    <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.products.addImage') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_id">Chọn sản phẩm</label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                <option value="">Chọn sản phẩm</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                            @error('image')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn-submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <style>
        /* Tổng thể */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            font-family: 'Arial', sans-serif;
        }

        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Nút Thêm sản phẩm */
        .btn-add {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .btn-add i {
            margin-right: 5px;
        }

        /* Bảng sản phẩm */
        .table-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
        }
        .product-table th, .product-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .product-table th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        .product-table tr:hover {
            background-color: #f8f9fa;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .no-data {
            text-align: center;
            color: #777;
            padding: 20px;
        }

        /* Modal */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-bottom: none;
            padding: 15px 20px;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        .modal-body {
            padding: 20px;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
        }
        .form-group.full-width {
            flex: none;
            width: 100%;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .form-control-file {
            padding: 5px 0;
        }
        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        .error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        .modal-footer {
            padding: 15px 20px;
            border-top: none;
        }
        .btn-close {
            background-color: #6c757d;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Thông báo */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 5px; /* Thêm khoảng cách giữa các ảnh */
        }
    </style>

@section('scripts')
    <!-- Font Awesome cho icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@endsection
