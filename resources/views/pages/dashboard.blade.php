@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Status Kependudukan Warga</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        {{-- Canvas untuk menampung grafik --}}
                        <canvas id="residentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        </div>

{{-- Script untuk menginisialisasi Chart.js --}}
<script>
    // Mengambil data dari controller yang sudah di-passing ke view
    const labels = @json($labels);
    const data = @json($data);

    // Konfigurasi untuk grafik (contoh: Pie Chart)
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Jumlah Warga',
            data: data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Mendapatkan elemen canvas
    const ctx = document.getElementById('residentChart').getContext('2d');

    // Membuat grafik baru
    const myChart = new Chart(ctx, {
        type: 'pie', // Tipe grafik: 'pie', 'bar', 'line', dll.
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + ' Warga';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection