<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Ruangan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px; /* Ukuran font lebih kecil agar muat */
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: middle; /* Agar teks di tengah secara vertikal */
        }
        th {
            background-color: #f2f2f2;
            text-align: center; /* Judul kolom di tengah */
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Data Barang Inventaris Ruangan</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No Urut</th>
                <th rowspan="2">Nama Barang/ Jenis Barang</th>
                <th rowspan="2">Merk/ Model</th>
                <th rowspan="2">Bahan</th>
                <th rowspan="2">Tahun Pembelian</th>
                <th rowspan="2">No. Kode Barang</th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Harga Beli (Rp)</th>
                <th colspan="3">Keadaan Barang</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Baik (B)</th>
                <th>Kurang Baik (KB)</th>
                <th>Rusak Berat (RB)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarBarang as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->merk_model }}</td>
                    <td>{{ $item->bahan }}</td>
                    <td class="text-center">{{ $item->tahun_pembelian }}</td>
                    <td class="text-center">{{ $item->kode_barang }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-end">{{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                    <td class="text-center">@if($item->kondisi == 'B') ✓ @endif</td>
                    <td class="text-center">@if($item->kondisi == 'KB') ✓ @endif</td>
                    <td class="text-center">@if($item->kondisi == 'RB') ✓ @endif</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    {{-- Colspan disesuaikan dengan total kolom (12) --}}
                    <td colspan="12" class="text-center">Data inventaris masih kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
