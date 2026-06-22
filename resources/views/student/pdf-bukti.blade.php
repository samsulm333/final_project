<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - {{ $registration->nomor_pendaftaran }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-data th, .table-data td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .table-data th { width: 35%; background-color: #f2f2f2; }
        .footer { text-align: right; margin-top: 50px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>BUKTI PENDAFTARAN PPDB ONLINE</h2>
        <p>Tahun Ajaran 2026/2027</p>
    </div>

    <table class="table-data">
        <tr>
            <th>Nomor Pendaftaran</th>
            <td><strong>{{ $registration->nomor_pendaftaran }}</strong></td>
        </tr>
        <tr>
            <th>Status Pendaftaran</th>
            <td>{{ strtoupper(str_replace('_', ' ', $registration->status)) }}</td>
        </tr>
        <tr>
            <th>Jalur Pilihan</th>
            <td>{{ $registration->jalur->nama }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $registration->student->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>NIK</th>
            <td>{{ $registration->student->nik }}</td>
        </tr>
        <tr>
            <th>Tempat, Tanggal Lahir</th>
            <td>{{ $registration->student->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->student->tanggal_lahir)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Asal Sekolah</th>
            <td>{{ $registration->student->sekolah_asal }}</td>
        </tr>
    </table>

    <p><strong>Catatan:</strong> Lembar ini adalah bukti pendaftaran yang sah. Harap disimpan dengan baik dan dibawa saat melakukan daftar ulang ke sekolah (jika dinyatakan lulus/terverifikasi).</p>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

</body>
</html>