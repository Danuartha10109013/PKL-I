<?php

namespace App\Http\Controllers;

use App\Models\ProdukM;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.landing-page');
    }
    public function product(Request $request)
    {
        $data=ProdukM::all();
        return view('pages.product.index',compact('data'));
    }
    public function customer(Request $request)
    {
        return view('pages.customer.index');
    }
    public function testimoni(Request $request)
    {
        return view('pages.testimoni.index');
    }
    public function kontak(Request $request)
    {
        return view('pages.kontak.index');
    }
    public function about(Request $request)
    {
        return view('pages.about.index');
    }


}
