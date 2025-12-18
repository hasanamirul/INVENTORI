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
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 16rem; /* w-64 */
            overflow-y: auto;
            background: #005f99;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, left 0.3s ease;
            z-index: 40;
            transform: translateX(0);
        }

        /* Sidebar hidden (all devices) */
        aside.sidebar-hidden {
            transform: translateX(-100%);
        }

        /* Desktop: sidebar visible by default */
        @media (min-width: 768px) {
            aside {
                display: block;
            }
        }

        /* Mobile: sidebar can be shown/hidden */
        @media (max-width: 767px) {
            aside {
                display: block;
                width: 100%;
                max-width: 16rem;
                z-index: 50;
            }
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
            padding: 1rem;
            padding-md: 2rem;
            margin: 0.5rem;
            margin-md: 1rem;
            width: calc(100% - 1rem);
            margin-left: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease, margin-left 0.3s ease, width 0.3s ease;
        }

        main:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        /* Desktop main layout */
        @media (min-width: 768px) {
            main {
                padding: 2rem;
                margin: 1rem;
                width: calc(100% - 17rem);
                margin-left: 17rem;
            }
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
            z-index: 60;
            background: #005f99;
            color: white;
            padding: 0.5rem 0.7rem;
            border-radius: 0.5rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .toggle-btn:hover {
            background: #0077b3;
            transform: scale(1.05);
        }

        /* Toggle button always visible */
        /* No media query - button visible on all devices */

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
    <aside id="sidebar" class="w-64 p-6 fixed z-40 bg-[#005f99] transition-all duration-300">
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
    <main id="mainContent" class="flex-1 transition-all duration-300">
        @yield('content')
    </main>

    <!-- Image preview modal (reusable) -->
    <div id="imagePreviewModal" class="image-modal hidden" aria-hidden="true">
        <div class="image-modal-backdrop"></div>
        <div class="image-modal-dialog">
            <button id="imageModalClose" class="image-modal-close">&times;</button>
            <div class="image-modal-body">
                <div class="image-preview-wrap">
                    <img id="imagePreviewLarge" src="" alt="Preview" />
                </div>
                <div class="image-meta">
                    <h3 id="metaName"></h3>
                    <p><strong>Kategori:</strong> <span id="metaKategori"></span></p>
                    <p><strong>Satuan:</strong> <span id="metaSatuan"></span></p>
                    <p><strong>Jumlah:</strong> <span id="metaJumlah"></span></p>
                    <p><strong>Status:</strong> <span id="metaStatus"></span></p>
                    <p><strong>Terpakai:</strong> <span id="metaTerpakai"></span></p>
                    <p><strong>Tanggal:</strong> <span id="metaTanggal"></span></p>
                    <p><strong>Keterangan:</strong> <span id="metaKeterangan"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const mainContent = document.getElementById('mainContent');

        // Sidebar toggle works on ALL devices
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-hidden');
        });

        // Close sidebar when clicking on a link (mobile only)
        if (window.innerWidth < 768) {
            document.querySelectorAll('#sidebar a, #sidebar button[type="submit"]').forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.add('sidebar-hidden');
                });
            });
        }

        // Ensure correct layout on load / resize
        function adjustLayoutOnResize() {
            const isMobile = window.innerWidth < 768;
            const isSidebarHidden = sidebar.classList.contains('sidebar-hidden');

            if (isMobile) {
                // Mobile: sidebar toggles independently
                if (!isSidebarHidden) {
                    mainContent.style.marginLeft = '1rem';
                    mainContent.style.width = 'calc(100% - 2rem)';
                } else {
                    mainContent.style.marginLeft = '1rem';
                    mainContent.style.width = 'calc(100% - 2rem)';
                }
            } else {
                // Desktop: sidebar toggles independently
                if (isSidebarHidden) {
                    mainContent.style.marginLeft = '1rem';
                    mainContent.style.width = 'calc(100% - 2rem)';
                } else {
                    mainContent.style.marginLeft = '17rem';
                    mainContent.style.width = 'calc(100% - 17rem)';
                }
            }
        }

        window.addEventListener('resize', adjustLayoutOnResize);
        window.addEventListener('load', adjustLayoutOnResize);
        adjustLayoutOnResize();

        // Modal handling
        const imageModal = document.getElementById('imagePreviewModal');
        const imagePreviewLarge = document.getElementById('imagePreviewLarge');
        const imageModalClose = document.getElementById('imageModalClose');

        function openImageModal(data) {
            imagePreviewLarge.src = data.image || '';
            document.getElementById('metaName').textContent = data.name || '-';
            document.getElementById('metaKategori').textContent = data.kategori || '-';
            document.getElementById('metaSatuan').textContent = data.satuan || '-';
            document.getElementById('metaJumlah').textContent = data.jumlah ?? '-';
            document.getElementById('metaStatus').textContent = data.status || '-';
            document.getElementById('metaTerpakai').textContent = data.terpakai ?? '-';
            document.getElementById('metaTanggal').textContent = data.tanggal || '-';
            document.getElementById('metaKeterangan').textContent = data.keterangan || '-';
            imageModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeImageModal() {
            imageModal.classList.add('hidden');
            imagePreviewLarge.src = '';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }

        imageModalClose.addEventListener('click', closeImageModal);
        document.querySelector('.image-modal-backdrop').addEventListener('click', closeImageModal);

        // Close modal with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !imageModal.classList.contains('hidden')) {
                closeImageModal();
            }
        });

        // delegate click on thumbnails
        document.addEventListener('click', function (e) {
            const thumb = e.target.closest('.img-thumb');
            if (!thumb) return;
            e.preventDefault();
            const data = {
                image: thumb.getAttribute('data-image'),
                name: thumb.getAttribute('data-name'),
                kategori: thumb.getAttribute('data-kategori'),
                satuan: thumb.getAttribute('data-satuan'),
                jumlah: thumb.getAttribute('data-jumlah'),
                status: thumb.getAttribute('data-status'),
                terpakai: thumb.getAttribute('data-terpakai'),
                tanggal: thumb.getAttribute('data-tanggal'),
                keterangan: thumb.getAttribute('data-keterangan'),
            };
            openImageModal(data);
        });
    </script>

    <style>
        /* Modal styles */
        .image-modal.hidden { display: none; }
        .image-modal { position: fixed; inset: 0; z-index: 1000; display: flex; align-items: center; justify-content: center; }
        .image-modal-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.6); }
        .image-modal-dialog { position: relative; background: #fff; width: 90%; max-width: 1000px; border-radius: 8px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
        .image-modal-close { position: absolute; right: 12px; top: 8px; z-index: 2; background: transparent; border: none; font-size: 28px; cursor: pointer; }
        .image-modal-body { display: flex; gap: 1rem; padding: 1rem; }
        .image-preview-wrap { flex: 1 1 60%; display:flex; align-items:center; justify-content:center; }
        .image-preview-wrap img { max-width:100%; max-height:70vh; object-fit:contain; }
        .image-meta { flex: 1 1 40%; padding: 0.5rem 1rem; overflow:auto; max-height: 70vh; }
        
        /* Tablet */
        @media (max-width: 1024px) {
            .image-modal-dialog { width: 95%; max-width: 900px; }
            .image-modal-body { gap: 0.5rem; padding: 0.75rem; }
            .image-meta { flex: 1 1 35%; padding: 0.5rem; font-size: 0.9rem; }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .image-modal-body { flex-direction: column; }
            .image-preview-wrap { flex: 1 1 100%; max-height: 50vh; }
            .image-preview-wrap img { max-height: 50vh; }
            .image-meta { flex: 1 1 100%; max-height: 30vh; padding: 0.75rem; font-size: 0.85rem; }
            .image-modal-dialog { width: 98%; max-width: 100%; }
        }

        /* Very small mobile */
        @media (max-width: 480px) {
            .image-modal-dialog { width: 100%; border-radius: 4px; }
            .image-modal-close { font-size: 24px; right: 8px; top: 4px; }
            .image-modal-body { gap: 0.25rem; padding: 0.5rem; flex-direction: column; }
            .image-preview-wrap { max-height: 40vh; }
            .image-preview-wrap img { max-height: 40vh; }
            .image-meta { max-height: 25vh; padding: 0.5rem; font-size: 0.8rem; }
            .image-meta p { margin: 0.3rem 0; }
        }
    </style>

</body>

</html>
