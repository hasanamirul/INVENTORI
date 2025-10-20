@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <!-- Judul Dashboard -->
    <h2 class="mb-8 text-center text-4xl font-extrabold"
        style="background: linear-gradient(90deg, #007bff, #28a745, #ffc107);
               -webkit-background-clip: text;
               -webkit-text-fill-color: transparent;
               text-shadow: 1px 1px 5px rgba(0,0,0,0.2);">
        DASHBOARD STATISTIK
    </h2>
    <br>
    <br>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Grafik Bar -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
            <h5 class="text-lg font-semibold text-center mb-4 text-white py-2 rounded-lg"
                style="background: linear-gradient(90deg,#007bff,#28a745); text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                Jumlah Data per Fitur
            </h5>
            <canvas id="barChart" style="max-height: 320px; width: 100%;"></canvas>
            <div class="mt-4 flex justify-around text-sm font-medium">
                <div><span class="inline-block w-4 h-4 bg-[#007bff] mr-1"></span> Barang</div>
                <div><span class="inline-block w-4 h-4 bg-[#ffc107] mr-1"></span> Rekap</div>
                <div><span class="inline-block w-4 h-4 bg-[#28a745] mr-1"></span> Pencatatan</div>
            </div>
        </div>

        <!-- Grafik Pie -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
            <h5 class="text-lg font-semibold text-center mb-4 text-white py-2 rounded-lg"
                style="background: linear-gradient(90deg,#28a745,#007bff); text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                Distribusi Data
            </h5>
            <canvas id="pieChart" style="max-height: 320px; width: 100%;"></canvas>
            <div class="mt-4 flex justify-around text-sm font-medium">
                <div><span class="inline-block w-4 h-4 bg-[#007bff] mr-1"></span> Barang</div>
                <div><span class="inline-block w-4 h-4 bg-[#ffc107] mr-1"></span> Rekap</div>
                <div><span class="inline-block w-4 h-4 bg-[#28a745] mr-1"></span> Pencatatan</div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['Barang', 'Rekap (Masuk + Keluar)', 'Pencatatan'];
    const dataCounts = [
        {{ $barangCount }},
        {{ $rekapCount }},
        {{ $pencatatanCount }}
    ];
    const colors = ['#007bff', '#ffc107', '#28a745'];

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Data',
                data: dataCounts,
                backgroundColor: colors,
                borderRadius: 8,
                hoverBackgroundColor: ['#0056b3', '#e0a800', '#1e7e34']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1000, easing: 'easeOutQuart' },
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataCounts,
                backgroundColor: colors,
                borderWidth: 1,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutBounce' },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
