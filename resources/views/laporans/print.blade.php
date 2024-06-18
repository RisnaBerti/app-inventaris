<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin: 5px 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .info-table .label {
            width: 180px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            margin-top: 20px;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 4px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .signatures {
            margin-top: 40px;
            width: 100%;
            text-align: center;
            clear: both;
        }

        .signatures div {
            display: inline-block;
            width: 45%;
            text-align: center;
        }

        .signatures div.left {
            margin-right: 10%;
        }

        .footer p {
            margin: 5px 0;
        }
        .tgl {
            /* di sebelah kanan dengan margin right 10 */
            text-align: right;
            margin-right: 2%;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>LAPORAN PENEMPATAN BARANG</h2>
        <h2>MA DARUL QUR'AN TAHUN {{ $tahun_akademik }}</h2> <!-- Menampilkan tahun akademik -->

        <br />

        <table class="info-table">
            <tr>
                <td class="label">NAMA SEKOLAH</td>
                <td>: MA DARUL QUR'AN WONOSARI</td>
            </tr>
            <tr>
                <td class="label">KECAMATAN</td>
                <td>: WONOSARI</td>
            </tr>
            <tr>
                <td class="label">KABUPATEN</td>
                <td>: GUNUNGKIDUL</td>
            </tr>
            <tr>
                <td class="label">PROVINSI</td>
                <td>: D.I YOGYAKARTA</td>
            </tr>
            <tr>
                <td class="label">RUANGAN</td>
                <td>: {{ $ruangan ? $ruangan->nama_ruangan : '-' }}</td> <!-- Menampilkan nama ruangan -->
            </tr>
            <tr>
                <td class="label">PERIODE</td>
                <td>: {{ $tahun_akademik }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tempat Simpan</th>
                    <th rowspan="2">Nama Barang</th>
                    <th rowspan="2">Kode Barang</th>
                    <th rowspan="2">Merek/Model (Type)</th>
                    <th rowspan="2">Ukuran</th>
                    <th rowspan="2">Bahan</th>
                    <th rowspan="2">Tahun Pembuatan/Pembelian</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">No Inventaris</th>
                    <th rowspan="2">Tahun Akademik</th>
                    <th colspan="3">Keadaan</th>
                </tr>
                <tr>
                    <th>Baik (B)</th>
                    <th>Kurang Baik (KB)</th>
                    <th>Rusak Berat (RB)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventaris as $inventari)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inventari->transak->ruangan->nama_ruangan }}</td>
                        <td>{{ $inventari->transak->barang->nama_barang }}</td>
                        <td>{{ $inventari->transak->barang->kode_barang }}</td>
                        <td>{{ $inventari->transak->barang->merk_model }}</td>
                        <td>{{ $inventari->transak->barang->ukuran }}</td>
                        <td>{{ $inventari->transak->barang->bahan }}</td>
                        <td>{{ $inventari->transak->barang->tahun_pembuatan_pembelian }}</td>
                        <td>{{ $inventari->transak->jml_mutasi }}</td>
                        <td>{{ $inventari->transak->no_inventaris }}</td>
                        <td>{{ $inventari->transak->tahun_akademik }}</td>
                        <td>{{ $inventari->jml_baik }}</td>
                        <td>{{ $inventari->jml_kurang_baik }}</td>
                        <td>{{ $inventari->jml_rusak_berat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="tgl">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY', 'Do MMMM YYYY') }}</p>

    <div class="signatures">
        <p>Mengetahui,</p>
        <div style="text-align: center;">
            <div style="float: left; width: 45%; text-align: center;">
                <p><strong>Kepala Sekolah</strong></p>
                <br><br><br>
                <p>{{ $kepsek_name }}</p>
            </div>
            <div style="float: right; width: 45%; text-align: center;">
                <p><strong>Waka Sarpras</strong></p>
                <br><br><br>
                <p>{{ $sapras_name }}</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} MA DARUL QUR'AN WONOSARI. All rights reserved.</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
