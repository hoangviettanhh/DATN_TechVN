<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="TechVN - Admin Dashboard">
<meta name="keywords" content="admin, dashboard, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="TechVN">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title') - TechVN Admin</title>

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

@stack('styles')
</head>
<body>

<div class="main-wrapper">
    <div class="header">
        <div class="header-left active">
            <a href="{{ url('admin') }}" class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
            </a>
            <a href="{{ url('admin') }}" class="logo-small">
                <img src="{{ asset('assets/img/icons/product.svg') }}" alt="">
            </a>
            <a id="toggle_btn" href="javascript:void(0);">
            </a>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <ul class="nav user-menu">
            <li class="nav-item dropdown has-arrow main-drop">
                <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="">
                        <span class="status online"></span>
                    </span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilename">
                        <div class="profileset">
                            <span class="user-img">
                                <img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="">
                                <span class="status online"></span>
                            </span>
                            <div class="profilesets">
                                <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                                <h5>Admin</h5>
                            </div>
                        </div>
                        <hr class="m-0">
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="me-2" data-feather="user"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                            <i class="me-2" data-feather="settings"></i>Settings
                        </a>
                        <hr class="m-0">
                        <a class="dropdown-item logout pb-0" href="{{ route('admin.logout') }}">
                            <img src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2" alt="img">Logout
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="{{ url('admin') }}">
                            <img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img">
                            <span> Dashboard</span>
                        </a>
                    </li>

                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                            <span> Danh mục</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('admin/menus/add') }}">Thêm danh mục</a></li>
                            <li><a href="{{ url('admin/menus/list') }}">Danh sách danh mục</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/expense1.svg') }}" alt="img">
                            <span>Thương hiệu</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('admin/brands/list') }}">Danh sách thương hiệu</a></li>
                            <li><a href="{{ url('admin/brands/add') }}">Thêm thương hiệu</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/sales1.svg') }}" alt="img">
                            <span> Sản Phẩm</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('admin/products/add') }}">Thêm sản phẩm</a></li>
                            <li><a href="{{ url('admin/products/listsp') }}">Danh sách sản phẩm</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

@stack('scripts')
</body>
</html> 