<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Operasional - {{ $reportMonth }}-{{ $reportYear }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Force white background for print page */
        body { background: #fff !important; font-family: sans-serif; padding: 30px; line-height: 1.4; color: #333; }
        /* Ensure colors print correctly */
        html, body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; text-transform: uppercase; font-size: 1.8rem; }
        .header p { margin: 3px 0; font-size: 0.9rem; }
        
        .title-area { text-align: center; margin-bottom: 25px; }
        .title-area h2 { margin: 0; font-size: 1.4rem; text-transform: uppercase; font-weight: 700; }
        .title-area p { margin: 5px 0 0 0; font-size: 1rem; color: #555; font-style: italic; }

        /* Stats Section */
        .stats-grid { display: flex; justify-content: space-between; margin-bottom: 25px; gap: 15px; }
        .stat-box { flex: 1; border: 1px solid #ccc; padding: 12px; border-radius: 6px; text-align: center; background: #fafafa; }
        .stat-box h4 { margin: 0 0 5px 0; font-size: 0.75rem; text-transform: uppercase; color: #666; letter-spacing: 0.5px; }
        .stat-box .number { font-size: 1.8rem; font-weight: bold; color: #111; margin: 0; }

        /* Table */
        .items { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.85rem; }
        .items th, .items td { border: 1px solid #333; padding: 10px 8px; text-align: left; vertical-align: top; }
        .items th { background: #f2f2f2; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; }
        .items td ul { margin: 0; padding-left: 15px; }
        
        /* Footer Signatures */
        .footer-sigs { margin-top: 50px; width: 100%; page-break-inside: avoid; }
        .footer-sigs td { width: 50%; text-align: center; font-size: 0.9rem; }
        .signature-space { height: 75px; }
        
        /* Controls */
        .print-controls { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn-print { background: #10B981; color: #000; border: none; padding: 10px 20px; font-weight: 700; border-radius: 6px; cursor: pointer; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
        .btn-print:hover { background: #059669; }
        .btn-close-print { background: #374151; color: #fff; border: none; padding: 10px 20px; font-weight: 600; border-radius: 6px; cursor: pointer; text-transform: uppercase; font-size: 0.8rem; }
        .btn-close-print:hover { background: #1f2937; }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print print-controls">
        <button onclick="window.print()" class="btn-print">Cetak Sekarang</button>
        <button onclick="window.close()" class="btn-close-print">Tutup</button>
    </div>

    @php
        $bulanIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $namaBulan = $bulanIndo[$reportMonth] ?? 'Tidak Diketahui';
    @endphp

    <div class="header">
        <h1>{{ $settings['company_name'] ?? 'HOUSE OF SALBAI' }}</h1>
        <p>{{ $settings['address'] ?? 'Alamat Perusahaan Belum Diatur' }}</p>
        <p>Email: {{ $settings['email'] ?? '-' }} | Telp: {{ $settings['phone'] ?? '-' }}</p>
    </div>

    <div class="title-area">
        <h2>Laporan Rekapitulasi Operasional &amp; Logistik</h2>
        <p>Periode Bulan: {{ $namaBulan }} {{ $reportYear }}</p>
    </div>

    <!-- Ringkasan Statistik Bulanan -->
    <div class="stats-grid">
        <div class="stat-box">
            <h4>Total Event / Manifes</h4>
            <div class="number">{{ $monthlyStats['total_manifests'] }}</div>
        </div>
        <div class="stat-box">
            <h4>Manifes Selesai (Kembali)</h4>
            <div class="number">{{ $monthlyStats['completed'] }}</div>
        </div>
        <div class="stat-box">
            <h4>Manifes Berjalan (Diluar)</h4>
            <div class="number">{{ $monthlyStats['ongoing'] }}</div>
        </div>
        <div class="stat-box">
            <h4>Total Alat Keluar (Unit)</h4>
            <div class="number">{{ $monthlyStats['total_items_qty'] }}</div>
        </div>
    </div>

    <!-- Tabel Detail Manifes Bulanan -->
    <h3>DAFTAR AKTIVITAS LOGISTIK BULANAN:</h3>
    <table class="items">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="15%">No. Manifes</th>
                <th width="15%">Tanggal Loading</th>
                <th width="20%">Nama Klien / Event</th>
                <th width="15%">Crew Chief</th>
                <th width="10%">Status</th>
                <th width="20%">Daftar Alat Bawaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportManifests as $index => $m)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $m->nomor_manifes }}</td>
                <td>{{ date('d-m-Y', strtotime($m->tanggal_loading)) }}</td>
                <td>{{ $m->klien_event }}</td>
                <td>{{ $m->crew_chief }}</td>
                <td>
                    <span style="font-weight: bold; color: {{ $m->status == 'Alat Kembali' ? '#10B981' : '#f59e0b' }};">
                        {{ $m->status }}
                    </span>
                </td>
                <td>
                    <!-- List of items inside manifest -->
                    @if($m->items && $m->items->count() > 0)
                        <ul>
                            @foreach($m->items as $item)
                                @if($item->inventory)
                                    <li>{{ $item->qty }}x {{ $item->inventory->nama_alat }}</li>
                                @endif
                            @endforeach
                            @if(is_array($m->additional_items))
                                @foreach($m->additional_items as $add)
                                    <li>{{ $add['qty'] ?? 1 }}x {{ $add['name'] }} (Tambahan)</li>
                                @endforeach
                            @endif
                        </ul>
                    @else
                        <span style="color: #888; font-style: italic;">Tidak ada alat terdaftar.</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                    Tidak ada aktivitas manifes yang tercatat pada bulan ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Approval -->
    <table class="footer-sigs">
        <tr>
            <td>
                Dibuat Oleh,<br>
                <strong>Admin Operasional Gudang</strong><br><br>
                <div class="signature-space"></div>
                ( .................................................. )
            </td>
            <td>
                Mengetahui &amp; Menyetujui,<br>
                <strong>Pimpinan / Owner House of Salbai</strong><br><br>
                <div class="signature-space"></div>
                ( .................................................. )
            </td>
        </tr>
    </table>

</body>
</html>
