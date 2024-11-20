<?php

namespace App\Http\Controllers;

use App\Models\SliderM;
use Illuminate\Http\Request;

class KSliderController extends Controller
{
    public function index (){
        $data = SliderM::all();
        return view('pages.admin.k-slider.index',compact('data'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'slider' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Limit to image types and size
        ]);

        // Retrieve the uploaded file
        $slider = $request->file('slider');

        // Define the storage path
        $sliderPath = $slider->getClientOriginalName();

        // Store the file
        $slider->storeAs('slider', $sliderPath,'public');


        // Create a new Kontak record
        SliderM::create([
            'image' => $sliderPath, 
        ]);

        // Redirect with success message
        return redirect()->route('admin.slider')->with('success', 'Kontak successfully added!');
    }

    public function delete ($id){
        $slider = SliderM::find($id);
        $slider->delete();
        return redirect()->back()->with('success', 'Data Has Been Deleted');
    }
}
