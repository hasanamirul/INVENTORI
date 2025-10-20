<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - HS Brand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f8f9fa;
        }

        main {
            flex: 1;
            padding: 120px;
        }

        footer {
            background: #0d6efd;
            color: white;
            text-align: center;
            padding: 12px 0;
            margin-top: auto;
        }

        /* Animasi masuk */
        .animate-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease-in-out;
        }

        .animate-left.show {
            opacity: 1;
            transform: translateX(0);
        }

        .animate-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease-in-out;
        }

        .animate-right.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* Card gradient lebih colorful */
        .card-gradient-1 {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
        }

        .card-gradient-2 {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
        }

        .card-gradient-3 {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .navbar-brand img {
                height: 30px;
            }

            .navbar-brand span {
                font-size: 0.9rem;
            }

            footer p {
                font-size: 0.8rem;
                margin: 0;
            }

            main {
                padding: 0 10px;
                padding-top: 60px;
            }
        

        @media (max-width: 768px) {
            .card h2 {
                font-size: 1.5rem;
            }

            .card h5 {
                font-size: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
                <img src="{{ asset('pemprov.png') }}" alt="Logo" class="me-2" style="height: 40px; width: auto; ">
                <span class="fw-bold">DISPERMADESDUKCAPIL JATENG</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger ms-2">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    {{-- Konten --}}
    <main class="flex-grow-1 " ">
        @yield('content')
    </main>


    {{-- Footer --}}
    <footer class="">
        <p class="mb-0 p-6">&copy; {{ date('Y') }} DISPERMADESDUKCAPIL PROVINSI JATENG | Dashboard Inventori Barang
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi scroll masuk
        function reveal() {
            document.querySelectorAll('.animate-left, .animate-right').forEach(el => {
                let windowHeight = window.innerHeight;
                let elementTop = el.getBoundingClientRect().top;
                if (elementTop < windowHeight - 50) {
                    el.classList.add('show');
                }
            });
        }
        window.addEventListener('scroll', reveal);
        window.addEventListener('load', reveal);
    </script>
    @stack('scripts')
</body>

</html>
