<?php

namespace App\Http\Controllers;

use App\Models\PesananM;
use App\Models\ProdukM;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function form($id){
        $data = ProdukM::find($id);
        return view('pages.product.form',compact('data'));
    }

    public function send(Request $request){
        // dd($request->all());
        // Validate the incoming data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email_perusahaan' => 'required|email|max:255',
            'prodct_id' => 'required|integer|exists:produk,id', 
        ]);

        $orders = PesananM::where('email',$request->email)
                            ->orWhere('email_perusahaan',$request->email_perusahaan)->count();
        // dd($orders);

        // Store the validated data in the UserProfile model (or your specific model)
        $pesanan = new PesananM();
        $pesanan->name = $validated['nama'];
        $pesanan->email = $validated['email'];
        $pesanan->whatsapp = $validated['no_whatsapp'];
        $pesanan->company_name = $validated['perusahaan'];
        $pesanan->alamat_perusahaan = $validated['alamat'];
        $pesanan->email_perusahaan = $validated['email_perusahaan'];
        $pesanan->product_id = $validated['prodct_id'];
        $pesanan->total_order = $orders + 1;

        $pesanan->save();

        $produk = ProdukM::find($pesanan->product_id);

        // WhatsApp message format
    
        // Nomor telepon harus dalam format internasional
        $nomor = '6282119072382'; // Ganti 0821 menjadi 62821 (62 adalah kode negara Indonesia)
        
        // Pesan WhatsApp
        $message = urlencode("Saya {$pesanan->name} dari {$pesanan->company_name} sangat tertarik dan ingin membeli produk dari PT. Trisurya Solusi Indo. Nama Produk: {$produk->name}");
        
        // URL WhatsApp
        $whatsappLink = "https://wa.me/{$nomor}?text={$message}";
        
        // Redirect atau tampilkan link
        header("Location: $whatsappLink");
        exit;
        
       

    }
}