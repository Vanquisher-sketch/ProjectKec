@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; }
    .card { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border-radius: 0.5rem; }
    .chart-container { position: relative; height: 18rem; width: 100%; }
</style>

<!-- Grid Container for Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Card for Status Kependudukan -->
    <div class="card bg-white p-6">
        <div class="flex items-center justify-between mb-4">
            <h6 class="text-lg font-semibold text-gray-700">Status Kependudukan</h6>
        </div>
        <div class="chart-container">
            <canvas id="statusKependudukanChart"></canvas>
        </div>
        <div class="mt-4 text-center text-sm text-gray-500 flex flex-wrap justify-center space-x-4" id="legendKependudukan">
            <!-- Legend akan dibuat oleh JavaScript -->
        </div>
    </div>

    <!-- Card for Data Tahun Kelahiran -->
    <div class="card bg-white p-6">
        <div class="flex items-center justify-between mb-4">
            <h6 class="text-lg font-semibold text-gray-700">Data Tahun Kelahiran</h6>
        </div>
        <div class="chart-container">
            <canvas id="tahunKelahiranChart"></canvas>
        </div>
        <div class="mt-4 text-center text-sm text-gray-500 flex flex-wrap justify-center space-x-4" id="legendTahunKelahiran">
            <!-- Legend akan dibuat oleh JavaScript -->
        </div>
    </div>

    <!-- Card for Data Status Pendidikan -->
    <div class="card bg-white p-6">
        <div class="flex items-center justify-between mb-4">
            <h6 class="text-lg font-semibold text-gray-700">Data Status Pendidikan</h6>
        </div>
        <div class="chart-container">
            <canvas id="statusPendidikanChart"></canvas>
        </div>
        <div class="mt-4 text-center text-sm text-gray-500 flex flex-wrap justify-center space-x-4" id="legendPendidikan">
            <!-- Legend akan dibuat oleh JavaScript -->
        </div>
    </div>

    <!-- Card for Data Status Pekerjaan -->
    <div class="card bg-white p-6">
        <div class="flex items-center justify-between mb-4">
            <h6 class="text-lg font-semibold text-gray-700">Data Status Pekerjaan</h6>
        </div>
        <div class="chart-container">
            <canvas id="statusPekerjaanChart"></canvas>
        </div>
        <div class="mt-4 text-center text-sm text-gray-500 flex flex-wrap justify-center space-x-4" id="legendPekerjaan">
            <!-- Legend akan dibuat oleh JavaScript -->
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const chartOptions = {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: (c) => `${c.label}: ${c.raw}` } } },
            cutout: '75%',
        };

        // Fungsi PINTAR untuk membuat chart dan MELAPORKAN ERROR
        async function createChartFromAPI(canvasId, legendId, apiUrl, backgroundColors) {
            const ctx = document.getElementById(canvasId);
            const legendContainer = document.getElementById(legendId);
            if (!ctx || !legendContainer) return;

            try {
                const response = await fetch(apiUrl);
                // Jika server merespon dengan error (misal: error 500 karena salah kolom)
                if (!response.ok) {
                    const errorData = await response.json(); // Ambil pesan error dari Laravel
                    throw new Error(errorData.message); // Lemparkan error agar ditangkap 'catch'
                }
                const apiData = await response.json();

                // Jika tidak ada data, tampilkan pesan
                if (apiData.labels.length === 0) {
                    const context = ctx.getContext('2d');
                    context.font = '16px Inter'; context.fillStyle = '#6b7280';
                    context.textAlign = 'center'; context.fillText('Tidak ada data', ctx.width / 2, ctx.height / 2);
                    return;
                }

                // Buat chart jika berhasil
                new Chart(ctx, { type: 'doughnut', data: { labels: apiData.labels, datasets: [{ data: apiData.data, backgroundColor: backgroundColors, borderColor: '#ffffff', borderWidth: 2 }] }, options: chartOptions });
                
                // Buat legend secara dinamis
                legendContainer.innerHTML = ''; // Kosongkan legend lama
                apiData.labels.forEach((label, index) => {
                    const color = backgroundColors[index % backgroundColors.length];
                    const legendItem = `
                        <span class="flex items-center">
                            <i class="fas fa-circle text-xs mr-1" style="color: ${color};"></i> ${label}
                        </span>`;
                    legendContainer.innerHTML += legendItem;
                });

            } catch (error) {
                // INI BAGIAN PENTINGNYA: Melaporkan error ke Console
                console.error(`[ERROR UNTUK DIAGRAM: ${canvasId}] ==> `, error.message);
                const context = ctx.getContext('2d');
                context.font = '16px Inter'; context.fillStyle = 'red';
                context.textAlign = 'center'; context.fillText('Error: Cek Console (F12)', ctx.width / 2, ctx.height / 2);
            }
        }

        // Panggil fungsi untuk setiap chart
        createChartFromAPI('statusKependudukanChart', 'legendKependudukan', `{{ route('chart.kependudukan') }}`, ['#3B82F6', '#10B981', '#F59E0B']);
        createChartFromAPI('tahunKelahiranChart', 'legendTahunKelahiran', `{{ route('chart.tahun_kelahiran') }}`, ['#6366F1', '#D946EF', '#14B8A6']);
        createChartFromAPI('statusPendidikanChart', 'legendPendidikan', `{{ route('chart.pendidikan') }}`, ['#EC4899', '#F97316', '#A855F7']);
        createChartFromAPI('statusPekerjaanChart', 'legendPekerjaan', `{{ route('chart.pekerjaan') }}`, ['#06B6D4', '#F43F5E']);
    });
</script>

<!-- Font Awesome diperlukan untuk ikon di legend dinamis -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
