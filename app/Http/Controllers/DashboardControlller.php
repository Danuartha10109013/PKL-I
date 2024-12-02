<?php

namespace App\Http\Controllers;

use App\Models\PembelianM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardControlller extends Controller
{
    public function index(){
        $pembelian = PembelianM::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(id) as total'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan');

    // Pastikan data terisi untuk semua bulan (1-12)
    $pembelianPerBulan = [];
    for ($i = 1; $i <= 12; $i++) {
        $pembelianPerBulan[] = $pembelian->get($i, 0); // Jika tidak ada data di bulan tertentu, default 0
    }
        return view('pages.admin.index',compact('pembelianPerBulan'));
    }
}
