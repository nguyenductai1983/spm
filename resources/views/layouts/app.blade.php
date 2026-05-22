<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống Quản lý Shipping Mark') - Agrina</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Premium Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --bg-color: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --border-radius: 12px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-custom .nav-link {
            font-weight: 500;
            color: #cbd5e1 !important;
            transition: color 0.2s ease-in-out;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #ffffff !important;
        }

        /* App Footer */
        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            font-size: 0.875rem;
            color: #64748b;
        }

        /* Cards and Elements Styling */
        .card-custom {
            background-color: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-weight: 550;
            transition: opacity 0.2s;
        }

        .btn-gradient-primary:hover {
            color: white;
            opacity: 0.9;
        }

        .btn-gradient-success {
            background: var(--secondary-gradient);
            color: white;
            border: none;
            font-weight: 550;
            transition: opacity 0.2s;
        }

        .btn-gradient-success:hover {
            color: white;
            opacity: 0.9;
        }

        /* Flash Messages */
        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 300px;
        }

        /* Page Headers */
        .page-header {
            font-weight: 700;
            color: #0f172a;
            position: relative;
            padding-bottom: 8px;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-box-seam-fill me-2 fs-4 text-info"></i>
                SHIPPING MARK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chi-tiets.*') ? 'active' : '' }}"
                                href="{{ route('chi-tiets.index') }}">Danh sách SM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('thong-bao.*') || request()->routeIs('containers.*') ? 'active' : '' }}"
                                href="{{ route('thong-bao.index') }}">Thông báo xuất hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('khach-hangs.*') ? 'active' : '' }}"
                                href="{{ route('khach-hangs.index') }}">Khách hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('hang-hoas.*') ? 'active' : '' }}"
                                href="{{ route('hang-hoas.index') }}">Hàng hóa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chi-tiet.import') ? 'active' : '' }}"
                                href="{{ route('chi-tiet.import') }}">Import Excel</a>
                        </li>
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') || request()->url() == route('users.index') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">Quản lý người dùng</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 me-2 text-info"></i>
                                <span>{{ auth()->user()->full_name ?? auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                                        <i class="bi bi-person-gear me-2"></i> Hồ sơ cá nhân
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-danger"
                                        href="javascript:void(0);"
                                        onclick="document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-info ms-2 px-3 py-1.5" href="{{ route('register') }}">Đăng ký</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-1">
        <!-- Toast Notification Area -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-floating shadow-lg" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-floating shadow-lg" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-1">&copy; {{ date('Y') }} - Agrina Shipping Mark Management System</p>
            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Phát triển trên nền tảng Laravel & Bootstrap 5</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS & jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto fadeout flash alerts after 4 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert-floating").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 4000);
        });
    </script>
    @yield('scripts')
</body>

</html>
