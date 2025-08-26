@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- Baris Pertama --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Grafik Rentang Usia</div>
                <div class="card-body"><canvas id="grafikUsia"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Grafik Status Pendidikan</div>
                <div class="card-body"><canvas id="grafikPendidikan"></canvas></div>
            </div>
        </div>

        {{-- Baris Kedua --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Grafik Status Pekerjaan</div>
                <div class="card-body"><canvas id="grafikPekerjaan"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Grafik Status Kependudukan</div>
                <div class="card-body"><canvas id="grafikKependudukan"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- 1. Sertakan library Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // SCRIPT UNTUK GRAFIK USIA (Bar)
    const labelsUsia = @json($labelsUsia);
    const dataUsia = @json($dataUsia);
    new Chart(document.getElementById('grafikUsia'), {
        type: 'bar',
        data: {
            labels: labelsUsia,
            datasets: [{ label: 'Jumlah Warga', data: dataUsia, backgroundColor: 'rgba(54, 162, 235, 0.6)' }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // SCRIPT UNTUK GRAFIK PENDIDIKAN (Bar)
    const labelsPendidikan = @json($labelsPendidikan);
    const dataPendidikan = @json($dataPendidikan);
    new Chart(document.getElementById('grafikPendidikan'), {
        type: 'bar',
        data: {
            labels: labelsPendidikan,
            datasets: [{ label: 'Jumlah Warga', data: dataPendidikan, backgroundColor: 'rgba(75, 192, 192, 0.6)' }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // SCRIPT UNTUK GRAFIK PEKERJAAN (Bar)
    const labelsPekerjaan = @json($labelsPekerjaan);
    const dataPekerjaan = @json($dataPekerjaan);
    new Chart(document.getElementById('grafikPekerjaan'), {
        type: 'bar',
        data: {
            labels: labelsPekerjaan,
            datasets: [{ label: 'Jumlah Warga', data: dataPekerjaan, backgroundColor: 'rgba(255, 159, 64, 0.6)' }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // =======================================================
    // SCRIPT BARU UNTUK GRAFIK KEPENDUDUKAN (Donat)
    // =======================================================
    const labelsKependudukan = @json($labelsKependudukan);
    const dataKependudukan = @json($dataKependudukan);
    new Chart(document.getElementById('grafikKependudukan'), {
        type: 'doughnut',
        data: {
            labels: labelsKependudukan,
            datasets: [{
                label: 'Jumlah Warga',
                data: dataKependudukan,
                backgroundColor: [
                    'rgba(67, 56, 202, 0.7)', // Indigo
                    'rgba(217, 119, 6, 0.7)'  // Amber
                ],
                borderColor: [
                    'rgba(67, 56, 202, 1)',
                    'rgba(217, 119, 6, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endsection