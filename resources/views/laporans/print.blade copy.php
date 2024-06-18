<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        h2, h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
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
            text-align: right;
        }
        .signatures p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
 
    <div class="container">
        <h2>LAPORAN PENEMPATAN BARANG</h2>
        <h4>MA DARUL QUR'AN TAHUN {{ date('Y') }}</h4>
 
        <br/>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Tempat Simpan</th>
                    <th>Baik (B)</th>
                    <th>Kurang Baik (KB)</th>
                    <th>Rusak Berat (RB)</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop untuk data inventaris --}}
                @foreach($data_inventaris as $inventaris)
                <tr>
                    <td>{{ $inventaris->nama_barang }}</td>
                    <td>{{ $inventaris->kode_barang }}</td>
                    <td>{{ $inventaris->nama_ruangan }}</td>
                    <td>{{ $inventaris->total_jumlah_baik }}</td>
                    <td>{{ $inventaris->total_jumlah_kurang_baik }}</td>
                    <td>{{ $inventaris->total_jumlah_rusak_berat }}</td>
                    <td>{{ $inventaris->total_jumlah }}</td>
                    <td>{{ $inventaris->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <script>
            window.print();
        </script>
        <p>&copy; {{ date('Y') }} MA DARUL QUR'AN. All rights reserved.</p>
    </div>

    <div class="signatures">
        <p>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY', 'Do MMMM YYYY') }}</p>
        <p>Mengetahui,</p>
        <div style="text-align: center;">
            <div style="float: left; width: 45%; text-align: center;">
                <p><strong>Kepala Sekolah</strong></p>
                <br><br><br>
                <p>Imron Rosidi, S.Pd.I</p>
            </div>
            <div style="float: right; width: 45%; text-align: center;">
                <p><strong>Waka Sarpras</strong></p>
                <br><br><br>
                <p>Nur Arifin, S.Pd</p>
            </div>
        </div>
    </div>
    
</body>
</html>
