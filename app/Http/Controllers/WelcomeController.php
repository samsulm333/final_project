<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $hasil_pencarian = null;
        $pesan_error = null;

        // Jika ada request pencarian dari form Cek Status
        if ($request->has('nomor_pendaftaran') && $request->nomor_pendaftaran != '') {
            
            $hasil_pencarian = Registration::with(['student', 'jalur'])
                ->where('nomor_pendaftaran', $request->nomor_pendaftaran)
                ->first();

            if (!$hasil_pencarian) {
                $pesan_error = "Data dengan nomor pendaftaran " . strtoupper($request->nomor_pendaftaran) . " tidak ditemukan.";
            }
        }

        return view('welcome', compact('hasil_pencarian', 'pesan_error'));
    }

    // Fungsi bantuan untuk menyamarkan nama (Budi Santoso -> Bu** S******)
    // public static function maskName($name)
    // {
    //     $words = explode(' ', $name);
    //     $maskedWords = array_map(function($word) {
    //         if (strlen($word) <= 2) return $word;
    //         return substr($word, 0, 2) . str_repeat('*', strlen($word) - 2);
    //     }, $words);
        
    //     return implode(' ', $maskedWords);
    // }
}