<?php

namespace App\Http\Controllers;

use App\Models\AboutM;
use App\Models\CustomerM;
use App\Models\KategoriM;
use App\Models\ProdukM;
use App\Models\TestimoniM;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.landing-page');
    }
    public function product(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        // Query ProdukM dengan filter search dan category
        $data = ProdukM::query()
            ->when($category, function ($query, $category) {
                $c = KategoriM::where('name',$category)->value('id');
                return $query->where('kategori_id', 'LIKE', '%' . $c . '%'); // Pastikan 'category' adalah kolom yang sesuai
            })
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->get();

        $category = KategoriM::all();

        return view('pages.product.index', compact('data', 'category', 'search'));
    }

    public function customer(Request $request)
    {
        $data = CustomerM::where('status', 1)->get();
        return view('pages.customer.index',compact('data'));
    }
    public function testimoni(Request $request)
    {
        $testimonials = TestimoniM::all();
        return view('pages.testimoni.index',compact('testimonials'));
    }
    public function kontak(Request $request)
    {
        return view('pages.kontak.index');
    }
    public function about(Request $request)
    {
        $data = AboutM::find(1);
        return view('pages.about.index',compact('data'));
    }


}
