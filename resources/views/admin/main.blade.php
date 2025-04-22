<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* Style cho submenu */
        .sidebar-menu .submenu > a {
            color: #5B6B95 !important;
            transition: all 0.3s ease;
            padding: 10px 15px;
            display: block;
        }
        
        .sidebar-menu .submenu > a:hover {
            color: #ffffff !important;
        }
        
        .sidebar-menu .submenu ul {
            padding: 5px 0;
            margin-top: 5px;
        }
        
        .sidebar-menu .submenu ul li {
            margin: 8px 0;
        }
        
        .sidebar-menu .submenu ul li a {
            color: #8B96B5 !important;
            padding: 8px 15px 8px 50px;
            transition: all 0.3s ease;
            font-size: 14px;
            display: block;
        }
        
        .sidebar-menu .submenu ul li a:hover {
            color: #ffffff !important;
            padding-left: 55px;
        }
        
        .sidebar-menu .submenu.active > a {
            color: #ffffff !important;
        }

        /* Style cho menu arrow */
        .menu-arrow {
            position: relative;
            margin-left: 8px;
            transition: transform 0.3s ease;
        }
        
        .submenu.active .menu-arrow {
            transform: rotate(90deg);
        }

        /* Style cho active item */
        .sidebar-menu .submenu ul li.active a {
            color: #ffffff !important;
        }

        /* Thêm spacing cho các menu chính */
        .sidebar-menu > ul > li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{ asset('assets/img/icons/product.svg') }}" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);"></a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv">
                                <img src="{{ asset('assets/img/icons/search.svg') }}" alt="img">
                            </a>
                        </form>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                        <img src="{{ asset('assets/img/icons/us1.png') }}" alt="" height="20">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/us.png" alt="" height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/fr.png" alt="" height="16"> French
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/es.png" alt="" height="16"> Spanish
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/de.png" alt="" height="16"> German
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/icons/notification-bing.svg') }}" alt="img"> 
                        <span class="badge rounded-pill">4</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti">Clear All</a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{ asset('assets/img/icons/avatar-02.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details">
                                                    <span class="noti-title">John Doe</span> added new task 
                                                    <span class="noti-title">Patient appointment booking</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                    <img src="assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span>
                                </span>
                                <div class="profilesets">
                                    <h6>John Doe</h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.html">
                                <i class="me-2" data-feather="user"></i> My Profile
                            </a>
                            <a class="dropdown-item" href="generalsettings.html">
                                <i class="me-2" data-feather="settings"></i>Settings
                            </a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html">
                                <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout
                            </a>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="{{ Request::is('admin') ? 'active' : '' }}">
                            <a href="{{ url('admin') }}">
                                <img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img">
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.list') }}">
                                <img src="{{ asset('assets/img/icons/product.svg') }}" alt="img">
                                <span>Danh mục</span>
                            </a>
                        </li>

                        <li class="{{ Request::is('admin/products*') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.list') }}">
                                <img src="{{ asset('assets/img/icons/sales1.svg') }}" alt="img">
                                <span>Sản Phẩm</span>
                            </a>
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

    <!-- Scripts -->
    <!-- jQuery trước tiên -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Các plugin phụ thuộc vào jQuery -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    
    <!-- Script chính -->
    <!-- <script src="{{ asset('assets/js/script.js') }}"></script> -->

    <!-- Script riêng của từng trang -->
    @yield('scripts')

    <script>
        // Kiểm tra jQuery đã load chưa
        if (typeof jQuery == 'undefined') {
            console.error('jQuery chưa được load!');
        } else {
            console.log('jQuery version:', jQuery.fn.jquery);
        }

        $(document).ready(function() {
            console.log('Main document ready');

            // Xử lý click vào menu có submenu
            $('.submenu > a').on('click', function(e) {
                e.preventDefault();
                var submenu = $(this).next('ul');
                var parent = $(this).parent();
                
                // Đóng tất cả các submenu khác
                $('.submenu ul').not(submenu).slideUp();
                $('.submenu').not(parent).removeClass('active');
                
                // Mở/đóng submenu hiện tại
                submenu.slideToggle();
                parent.toggleClass('active');
            });

            // Đóng submenu khi click ra ngoài
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.submenu').length) {
                    $('.submenu ul').slideUp();
                    $('.submenu').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>