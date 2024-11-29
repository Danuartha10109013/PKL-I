<?php

namespace App\Http\Controllers;

use App\Models\PembelianM;
use App\Models\PesananM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KPesananController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Retrieve records from PesananM, applying the search if there's a query
        $data = PesananM::query()
            ->when($search, function($query) use ($search) {
                // Apply the search filter on 'name' or 'company_name'
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('company_name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the data to the view 'pages.admin.k-pesanan.index'
        return view('pages.admin.k-pesanan.index', compact('data'));
    }

    public function active($id){
        $data = PesananM::find($id);

        $user= new User();
        $user->name = $data->name;
        $user->username = $data->name;
        $user->email = $data->email;
        $user->role = 1;
        $user->active = 1;
        $user->password = Hash::make('Trisurya');
        $user->save();

        $jadi = new PembelianM();
        $jadi->user_id = $user->id;
        $jadi->product_id = $id;
        $jadi->save();


        return redirect()->back()->with('success', 'User Has Been Created');
    }

    public function message($id){
        $data = PesananM::find($id);

        $nomor = $data->whatsapp; // Ganti 0821 menjadi 62821 (62 adalah kode negara Indonesia)
        
        // Pesan WhatsApp
        $message = urlencode("Terimakasih telah menghubungi Kami, Akun Anda telah dibuatkan");
        
        // URL WhatsApp
        $whatsappLink = "https://wa.me/{$nomor}?text={$message}";

        header("Location: $whatsappLink");
        exit;
    }
}
