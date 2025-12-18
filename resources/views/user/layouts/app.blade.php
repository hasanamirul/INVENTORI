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
            background: linear-gradient(180deg, #f3f7fb 0%, #f8fbff 100%);
        }

        main {
            flex: 1;
            padding: 120px 20px;
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

        /* Card gradient */
        .card-gradient-1 { background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; }
        .card-gradient-2 { background: linear-gradient(135deg, #ff416c, #ff4b2b); color: white; }
        .card-gradient-3 { background: linear-gradient(135deg, #11998e, #38ef7d); color: white; }

        /* Navbar / footer enhancements */
        .navbar { transition: all 0.25s ease; backdrop-filter: blur(6px); }
        .navbar .nav-link { transition: transform 0.18s ease, box-shadow 0.18s ease; border-radius: 8px; padding: 8px 12px; }
        .navbar .nav-link:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(13,110,253,0.18); background: rgba(255,255,255,0.06); }
        .navbar .navbar-brand { transition: transform 0.18s ease; }
        .navbar .navbar-brand:hover { transform: translateY(-2px); }

        footer.footer-modern {
            background: linear-gradient(90deg, rgba(3,169,244,1) 0%, rgba(13,110,253,1) 100%);
            color: white;
            padding: 18px 12px;
            margin-top: auto;
            box-shadow: 0 -6px 30px rgba(3,169,244,0.08);
        }

        footer.footer-modern .footer-inner { max-width:1100px; margin:0 auto; display:flex; gap:12px; align-items:center; justify-content:center; flex-direction:column }

        .social-btn { background:rgba(255,255,255,0.08); padding:8px 10px; border-radius:8px; color:#fff; transition:all 0.18s ease }
        .social-btn:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(3,169,244,0.12); background:rgba(255,255,255,0.12) }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .navbar-brand img { height: 30px; }
            .navbar-brand span { font-size: 0.9rem; }
            footer p { font-size: 0.8rem; margin: 0; }
            main { padding: 0 10px; padding-top: 80px; }
        }

        @media (max-width: 768px) {
            .card h2 { font-size: 1.5rem; }
            .card h5 { font-size: 1rem; }
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
                    @auth
                        <li class="nav-item ms-3">
                            <button class="btn btn-link nav-link p-0" data-bs-toggle="modal" data-bs-target="#profileModal" style="background:none;border:none;padding:0;">
                                <img src="{{ auth()->check() && auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('pemprov.png') }}" alt="avatar" style="width:40px;height:40px;object-fit:cover;border-radius:50%;border:2px solid #fff;" />
                            </button>
                        </li>
                        <li class="nav-item ms-2">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger ms-2">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

        <!-- Profile Modal -->
        @auth
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Profil Saya</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('pemprov.png') }}" alt="avatar" style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:2px solid #ddd;" class="me-3" />
                            <div>
                                <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-3">
                            <li><strong>NIP:</strong> {{ auth()->user()->nip ?? '-' }}</li>
                            <li><strong>Bidang:</strong> {{ auth()->user()->bidang ?? '-' }}</li>
                        </ul>

                        <div>
                            <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#profileEditForm" aria-expanded="false" aria-controls="profileEditForm">
                                Edit Profil
                            </button>

                            <div class="collapse" id="profileEditForm">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="mb-2">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required />
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required />
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <label class="form-label">NIP</label>
                                            <input type="text" name="nip" class="form-control" value="{{ old('nip', auth()->user()->nip) }}" />
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="form-label">Bidang</label>
                                            <input type="text" name="bidang" class="form-control" value="{{ old('bidang', auth()->user()->bidang) }}" />
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Foto Profil (opsional)</label>
                                        <input type="file" name="photo" accept="image/*" class="form-control" />
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#profileEditForm">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endauth


    {{-- Konten --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>


    {{-- Footer --}}
    <footer class="footer-modern">
        <div class="footer-inner">
            <div class="text-center">
                <strong>DISPERMADESDUKCAPIL PROVINSI JATENG</strong>
                <div style="font-size:13px; opacity:0.9">&copy; {{ date('Y') }} | Dashboard Inventori Barang</div>
            </div>
        </div>
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
