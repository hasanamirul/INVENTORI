@extends('user.layouts.app')

@section('content')
<div class="container py-5">

    <!-- Judul -->
    <div class="text-center mb-5 animate-left">
        <h1 class="fw-bold text-primary">
            INVENTORI BARANG <br>
            DISPERMADESDUKCAPIL PROVINSI JATENG
        </h1>
        <p class="text-muted">Informasi ringkas barang masuk & keluar</p>
    </div>

    <!-- Statistik Card -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-4 animate-left">
            <div class="card card-gradient-1 shadow-lg border-0 rounded-4 text-center p-4">
                <h5>Total Barang</h5>
                <h2 class="fw-bold">{{ $totalBarang }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4 animate-left">
            <div class="card card-gradient-2 shadow-lg border-0 rounded-4 text-center p-4">
                <h5>Barang Masuk</h5>
                <h2 class="fw-bold">{{ $totalMasuk }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4 animate-left">
            <div class="card card-gradient-3 shadow-lg border-0 rounded-4 text-center p-4">
                <h5>Barang Keluar</h5>
                <h2 class="fw-bold">{{ $totalKeluar }}</h2>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card shadow-lg border-0 rounded-4 p-4 mb-5 animate-right">
        <h5 class="mb-4 text-center">Grafik Barang Masuk & Keluar per Bulan</h5>
        <div class="row">
            <div class="col-12 col-lg-8">
                <canvas id="barangChart" height="120"></canvas>
            </div>
            <div class="col-12 col-lg-4 mt-4 mt-lg-0 d-flex flex-column align-items-center justify-content-center">
                <h6 class="mb-3">Rasio Masuk vs Keluar</h6>
                <canvas id="ratioChart" style="max-width:220px;"></canvas>
                <div class="mt-3 d-flex gap-2">
                    <button id="toggleMasuk" class="btn btn-sm btn-outline-light" style="background:rgba(54,162,235,0.15);border:1px solid rgba(54,162,235,0.25)">Toggle Masuk</button>
                    <button id="toggleKeluar" class="btn btn-sm btn-outline-light" style="background:rgba(255,99,132,0.12);border:1px solid rgba(255,99,132,0.22)">Toggle Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Barang Masuk -->
    <div class="animate-left mb-5">
        <h5 class="mb-3 text-center">Tabel Barang Masuk Terbaru</h5>
        <div class="table-responsive shadow-lg rounded-2 overflow-hidden">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($barangMasuk as $index => $item)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Barang Keluar -->
    <div class="animate-left mb-5">
        <h5 class="mb-3 text-center">Tabel Barang Keluar Terbaru</h5>
        <div class="table-responsive shadow-lg rounded-2 overflow-hidden">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($barangKeluar as $index => $item)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($labels);
const dataMasuk = @json($masuk);
const dataKeluar = @json($keluar);

const ctx = document.getElementById('barangChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Barang Masuk',
                data: dataMasuk,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderRadius: 10
            },
            {
                label: 'Barang Keluar',
                data: dataKeluar,
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderRadius: 10
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'top' },
            tooltip: { enabled: true, mode: 'nearest', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

// Ratio donut chart
const totalMasuk = dataMasuk.reduce((a,b) => a + b, 0);
const totalKeluar = dataKeluar.reduce((a,b) => a + b, 0);
const ratioCtx = document.getElementById('ratioChart').getContext('2d');
const ratioChart = new Chart(ratioCtx, {
    type: 'doughnut',
    data: {
        labels: ['Masuk','Keluar'],
        datasets: [{
            data: [totalMasuk, totalKeluar],
            backgroundColor: ['rgba(54,162,235,0.9)','rgba(255,99,132,0.9)'],
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
        }
    }
});

// Toggle datasets
const barChart = Chart.getChart(ctx.canvas);
document.getElementById('toggleMasuk').addEventListener('click', function(){
    const ds = barChart.data.datasets[0];
    ds.hidden = !ds.hidden;
    barChart.update();
});
document.getElementById('toggleKeluar').addEventListener('click', function(){
    const ds = barChart.data.datasets[1];
    ds.hidden = !ds.hidden;
    barChart.update();
});

// Animasi scroll masuk
function reveal() {
    document.querySelectorAll('.animate-left, .animate-right').forEach(el => {
        let windowHeight = window.innerHeight;
        let elementTop = el.getBoundingClientRect().top;
        if(elementTop < windowHeight - 100){
            el.classList.add('show');
        }
    });
}
window.addEventListener('scroll', reveal);
window.addEventListener('load', reveal);
</script>
@endpush
