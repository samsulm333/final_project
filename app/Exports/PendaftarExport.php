<?php
namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class PendaftarExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $rowNumber = 0;

    public function collection()
    {
        return Registration::with(['student', 'jalur'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'NIK',
            'Jalur',
            'Status Pendaftaran',
            'Asal Sekolah',
            'Nilai Rata-Rata'
        ];
    }

    public function map($registration): array
    {
        $this->rowNumber++;
        
        return [
            $this->rowNumber,
            $registration->nomor_pendaftaran,
            $registration->student->nama_lengkap,
            // Prefix tanda kutip agar NIK tidak dibaca sebagai notasi ilmiah (E+) oleh Excel
            "'" . $registration->student->nik,
            $registration->jalur->nama ?? '-',
            strtoupper(str_replace('_', ' ', $registration->status)),
            $registration->student->sekolah_asal,
            $registration->student->nilai_rata_rata,
        ];
    }
}