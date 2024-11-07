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
        return view('pages.admin.k-produk.edit',compact('data'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        dd($request->all());
        // Validate the incoming data
        $request->validate([
            'kode_produk' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sfesifikasi' => 'nullable|array',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga' => 'required|numeric',
            'jenis_id' => 'required|exists:jenis,id',
            'kategori_id' => 'required|exists:kategori,id',
        ]);
    
        // Find the product by ID
        $product = ProdukM::findOrFail($id);
    
        // Update the basic product fields
        $product->kode_produk = $request->kode_produk;
        $product->name = $request->name;
        $product->deskripsi = $request->deskripsi;
        $product->harga = $request->harga;
        $product->jenis_id = $request->jenis_id;
        $product->kategori_id = $request->kategori_id;
    
        // Handle Specifications (if any)
        if ($request->has('sfesifikasi')) {
            $product->sfesifikasi = json_encode($request->sfesifikasi);  // Store as JSON
        }
    
        // Handle Images (if any)
        if ($request->hasFile('gambar')) {
            // Decode the existing images
            $img = json_decode($product->gambar, true) ?? [];
    
            $images = [];
            foreach ($request->file('gambar') as $image) {
                // Upload new image
                $imagePath = $image->store('products', 'public');  // Store images in 'public/products' directory
                $images[] = $imagePath;
            }
    
            // If the request has images to delete
            if ($request->has('delete_gambar')) {
                $deleteGambar = $request->delete_gambar;
                foreach ($deleteGambar as $key => $delete) {
                    if ($delete) {
                        // Remove the image from storage
                        $imagePathToDelete = $img[$key];  // Get the old image path
                        Storage::disk('public')->delete($imagePathToDelete);
                    }
                }
            }
    
            // Merge the new images with the old ones
            $product->gambar = json_encode(array_merge($images, $img));
        }
    
        // Save the updated product
        $product->save();
    
        // Redirect back or to the product list page
        return redirect()->back()->with('success', 'Product updated successfully.');
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
