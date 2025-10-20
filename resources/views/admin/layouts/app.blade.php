<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dispermades Inventory')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('boxes.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #e6f2fa;
        }

        /* Sidebar */
        aside {
            min-height: 110vh;
            background: #005f99;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        aside h1 {
            color: #ffffff;
            font-weight: 800;
            text-align: center;
        }

        aside nav ul li a,
        aside nav ul li button {
            color: #ffffff;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem;
            display: block;
            border-radius: 0.5rem;
        }

        aside nav ul li a:hover,
        aside nav ul li button:hover {
            background-color: #0077b3;
            transform: translateX(5px);
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        aside nav ul li button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        /* Main content */
        main {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 1rem;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        main:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        /* Logo */
        .logo {
            display: block;
            margin: 0 auto 1rem auto;
            width: 100px;
            height: auto;
        }

        /* Toggle button */
        .toggle-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            background: #005f99;
            color: white;
            padding: 0.5rem 0.7rem;
            border-radius: 0.5rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .toggle-btn:hover {
            background: #0077b3;
        }

        /* Sidebar hidden */
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="flex min-h-screen">

    <!-- Toggle Button (desktop & mobile) -->
    <button id="sidebarToggle" class="toggle-btn">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 p-6 fixed md:relative z-40 bg-[#005f99] transition-all duration-300">
        <!-- Logo -->
        <img src="{{ asset('pemprov.png') }}" alt="Logo Pemprov" class="logo">
        <h1 class="text-2xl mb-4">INVENTORI BARANG</h1>
        <h1 class="text-m mb-2">DISPERMADESDUKCAPIL</h1>
        <h1 class="text-xl mb-8">PROVINSI JATENG</h1>
        <nav>
            <ul>
                <li class="mb-2"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>
                        Dashboard</a></li>
                <li class="mb-2"><a href="{{ route('admin.kategori-barang.index') }}"><i class="bi bi-tags"></i>
                        Kategori Barang</a></li>
                <li class="mb-2"><a href="{{ route('admin.barang.index') }}"><i class="bi bi-box-seam"></i> Mutasi
                        Barang</a></li>
                <li class="mb-2"><a href="{{ route('admin.barang-masuk.index') }}"><i
                            class="bi bi-arrow-down-circle"></i> Barang Masuk</a></li>
                <li class="mb-2"><a href="{{ route('admin.barang-keluar.index') }}"><i
                            class="bi bi-arrow-up-circle"></i> Barang Keluar</a></li>
                <li class="mb-2"><a href="{{ route('admin.laporan.index') }}"><i class="bi bi-archive"></i> Laporan
                        Barang</a></li>
                <li class="mt-4">
                    <form method="POST" action="{{ route('logout') }}"> @csrf
                        <button type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="mainContent" class="flex-1 md:ml-54 transition-all duration-300">
        @yield('content')
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-hidden');

            // Jika sidebar disembunyikan di desktop, geser main content
            if (sidebar.classList.contains('sidebar-hidden')) {
                mainContent.classList.remove('md:ml-54');
            } else {
                mainContent.classList.add('md:ml-54');
            }
        });
    </script>

</body>

</html>
