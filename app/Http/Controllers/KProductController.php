<?php

namespace App\Http\Controllers;

use App\Models\JenisM;
use App\Models\KategoriM;
use App\Models\ProdukM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KProductController extends Controller
{
    public function index (){
        $data = ProdukM::all();
        $types= JenisM::all();
        $categories= KategoriM::all();
        return view('pages.admin.k-produk.index',compact('data','types','categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'kode_produk' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'harga' => 'required|numeric',
        'sfesifikasi' => 'required|array', // Ensure this is an array
        'gambar' => 'required|array', // Ensure this is an array
        'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Each image file validation
        'jenis_id' => 'required|integer',
        'kategori_id' => 'required|integer',
    ]);

    // Initialize an array to store the relative paths of uploaded images
    $uploadedImages = [];

    if ($request->hasFile('gambar')) {
        foreach ($request->file('gambar') as $image) {
            // Define the storage path with the format "public/images/products/{kode_produk}/{original_filename}"
            $filename = $image->getClientOriginalName();
            $path = $image->storeAs("images/products/{$request->kode_produk}", $filename, 'public');
            
            // Store only the relative path (e.g., "images/products/{kode_produk}/{filename}") in the array
            $uploadedImages[] = $path;
        }
    }

    // Create the product record with JSON encoded specifications and images
    ProdukM::create([
        'kode_produk' => $request->kode_produk,
        'name' => $request->name,
        'deskripsi' => $request->deskripsi,
        'harga' => $request->harga,
        'sfesifikasi' => json_encode($request->sfesifikasi), // Encode specs as JSON
        'gambar' => json_encode($uploadedImages), // Encode image paths as JSON
        'jenis_id' => $request->jenis_id,
        'kategori_id' => $request->kategori_id,
    ]);

        return redirect()->route('admin.product')->with('success', 'Product added successfully');
    }

    public function edit($id){
        $data = ProdukM::find($id);
        $types= JenisM::all();
        $categories= KategoriM::all();
        return view('pages.admin.k-produk.edit',compact('data','types','categories'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validate the incoming data
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sfesifikasi' => 'nullable|array',
            'gambar' => 'nullable|array',
            'gambar.*' => 'nullable',
            'harga' => 'required|numeric',
            'jenis_id' => 'required|exists:jenis,id',
            'kategori_id' => 'required|exists:kategori,id',
            'delete_gambar' => 'nullable|array',
            'delete_gambar.*' => 'integer',
        ]);

        // Find the product by ID
        $product = ProdukM::findOrFail($id);

        // Update basic product fields
        $product->kode_produk = $request->kode_produk;
        $product->name = $request->name;
        $product->deskripsi = $request->deskripsi;
        $product->harga = $request->harga;
        $product->jenis_id = $request->jenis_id;
        $product->kategori_id = $request->kategori_id;

        if ($request->has('sfesifikasi')) {
            // Filter out any null values
            $sfesifikasi = array_filter($request->sfesifikasi, function($value) {
                return !is_null($value);
            });
        
            // Check if there are any non-null specifications left
            if (!empty($sfesifikasi)) {
                $product->sfesifikasi = json_encode($sfesifikasi);
            }
        }

        foreach ($request->gambar as $newImage) {
            if ($request->hasFile('gambar')) {
                foreach ($request->file('gambar') as $image) {
                    $filename = $image->getClientOriginalName();
                    $path = $image->storeAs("images/products/{$request->kode_produk}", $filename, 'public');
                    
                    $uploadedImages[] = $path;
                }
            } else {
                // If no file is uploaded and the image is in the array (non-file data), add it
                foreach ($request->gambar as $image) {
                    $uploadedImages[] = $image;
                }
            }
        }
        

        // After processing all the new images, update the 'gambar' field in the database
        $product->gambar = json_encode($uploadedImages);
        // Save the updated product
        $product->save();

        return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
    
    }

    // Delete Product (and optionally images)
    public function delete($id)
    {
        // Find the product by ID
        $product = ProdukM::findOrFail($id);

        // Delete associated images (if any)
        if ($product->gambar) {
            $images = json_decode($product->gambar);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);  // Delete image from storage
            }
        }

        // Delete the product from the database
        $product->delete();

        // Redirect back or to the product list page
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

}
