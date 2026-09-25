<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan - {{ $m->nomor_manifes }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Force white background for print page (override admin theme) */
        body { background: #fff !important; font-family: sans-serif; padding: 30px; line-height: 1.4; color: #333; }
        /* Ensure colors print correctly */
        html, body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .content { margin-top: 20px; }
        .content h3 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items th, .items td { border: 1px solid #333; padding: 8px; text-align: left; }
        .items th { background: #f2f2f2; }
        .footer { margin-top: 50px; width: 100%; }
        .footer td { width: 33%; text-align: center; }
        .signature-space { height: 80px; }
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

    <div class="header">
        <h1>{{ $settings['company_name'] ?? 'HOUSE OF SOUND' }}</h1>
        <p>{{ $settings['address'] ?? 'Alamat Perusahaan Belum Diatur' }}</p>
        <p>Email: {{ $settings['email'] ?? '-' }} | Telp: {{ $settings['phone'] ?? '-' }}</p>
    </div>

    <h2 class="center-heading">SURAT JALAN / MANIFES ALAT</h2>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nomor</strong></td>
            <td width="35%">: {{ $m->nomor_manifes }}</td>
            <td width="15%"><strong>Kepada</strong></td>
            <td width="35%">: {{ $m->klien_event }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ date('d F Y', strtotime($m->tanggal_loading)) }}</td>
            <td><strong>Crew Chief</strong></td>
            <td>: {{ $m->crew_chief }}</td>
        </tr>
    </table>

    <div class="content">
        <h3>DAFTAR ALAT YANG DIBAWA:</h3>
        <table class="items">
            <thead>
                <tr>
                    <th width="10%">No.</th>
                    <th width="70%">Nama Alat / Spesifikasi</th>
                    <th width="20%">Jumlah (Qty)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-section-header"><td colspan="3"><strong>A. ALAT INVENTARIS</strong></td></tr>
                @php $no = 1; @endphp
                @forelse($m->items as $item)
                <tr>
                    <td class="td-center">{{ $no++ }}</td>
                    <td>{{ $item->inventory->nama_alat }} ({{ $item->inventory->kategori }})</td>
                    <td class="td-center">{{ $item->qty }} Unit</td>
                </tr>
                @empty
                <tr><td colspan="3" class="td-center ex-style-4632cffb" >Tidak ada alat inventaris yang dibawa.</td></tr>
                @endforelse

                @if($m->additional_items && count($m->additional_items) > 0)
                <tr class="tr-section-header"><td colspan="3"><strong>B. ALAT TAMBAHAN / LUAR</strong></td></tr>
                @foreach($m->additional_items as $add)
                <tr>
                    <td class="td-center">{{ $no++ }}</td>
                    <td>{{ $add['name'] }}</td>
                    <td class="td-center">{{ $add['qty'] }} Unit</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        @if($m->catatan)
        <div class="mt-4">
            <p class="mb-1"><strong>CATATAN TAMBAHAN:</strong></p>
            <div class="note-box">
                {{ $m->catatan }}
            </div>
        </div>
        @endif
    </div>

    <table class="footer">
        <tr>
            <td>
                Dibuat Oleh,<br><br>
                <div class="signature-space"></div>
                ( ............................ )<br>
                Admin
            </td>
            <td>
                Crew Chief,<br><br>
                <div class="signature-space"></div>
                ( <strong>{{ $m->crew_chief }}</strong> )
            </td>
            <td>
                Penerima/Klien,<br><br>
                <div class="signature-space"></div>
                ( ............................ )
            </td>
        </tr>
    </table>

</body>
</html>
