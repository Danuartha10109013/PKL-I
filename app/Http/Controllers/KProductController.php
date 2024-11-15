<?php

namespace App\Http\Controllers;

use App\Models\JenisM;
use App\Models\KategoriM;
use App\Models\ProdukM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KProductController extends Controller
{
    public function index(Request $request) {
        // Retrieve the search filter from the URL query parameter (either category or type)
        $filter = $request->get('filter'); // Get the filter parameter from URL
    
        // Fetch categories and types
        $types = JenisM::all();
        $categories = KategoriM::all();
    
        // Fetch data based on the filter
        if ($filter) {
            // Apply the filter to the query
            $data = ProdukM::where('kategori_id', $filter) // Filter by category name
                            ->orWhere('jenis_id', $filter) // Filter by jenis name
                            ->get();
        } else {
            // Fetch all data if no filter is applied
            $data = ProdukM::all();
        }
    
        // Return the view with the data
        return view('pages.admin.k-produk.index', compact('data', 'types', 'categories'));
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

    public function kategori(Request $request){

        $kategori = new KategoriM();
        $kategori->name = $request->nama_kategori;
        $kategori->deskripsi = $request->deskripsi_kategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori Telah Ditambahkan');
        
    }

    public function kategori_delete($id){
        $data = KategoriM::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Kategori Telah Dihapus');

    }
    public function jenis(Request $request){
        $jenia = new JenisM();
        $jenia->name = $request->nama_jenis;
        $jenia->deskripsi = $request->deskripsi_jenis;
        $jenia->save();

        return redirect()->back()->with('success', 'Jenis Telah Ditambahkan');
    }

}
