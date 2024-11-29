<?php

namespace App\Http\Controllers;

use App\Models\PembelianM;
use Illuminate\Http\Request;

class KPembelianController extends Controller
{
    public function index(){
        $data = PembelianM::all();
        return view('pages.admin.k-pembelian.index',compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Find the Pembeli by ID
        $pembeli = PembelianM::findOrFail($id);

        // Validate the input data
        $request->validate([
            'product' => 'required|string', // You can add specific validation for 'product'
            'bukti' => 'nullable|file|mimes:jpeg,png,pdf,docx|max:2048', // Add validation for 'bukti' file
        ]);

        // Update the status field
        $pembeli->status = $request->input('product');
        
        // Handle the file upload if there's a file
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            // Store the file in the storage folder
            $filePath = $file->storeAs('bukti', $file->getClientOriginalName(),'public');
            // You can update the database with the path of the file
            $pembeli->bukti = $filePath;
        }

        // Save the changes to the model
        $pembeli->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
