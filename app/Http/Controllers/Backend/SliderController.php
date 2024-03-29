<?php

namespace App\Http\Controllers\Backend;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = auth()->user()->id;
        $data = [
            'user_id'   => $user,
            'title'     => $request->get('title'),
            'sub_title' => $request->get('sub_title'),
            'link'      => $request->get('link'),
            'link_name' => $request->get('link_name'),
        ];
        if($request->hasFile('image')){
            $data['image'] = imageStore($request, 'image','slider', 'uploads/images/slider/');
        }


        try{
            Slider::create($data);
            Alert::success('Slider Inserted', 'Slider Successfully Inserted');
            return redirect()->route('slider.index');
        } catch(\Exception $ex) {
            Alert::error('DataInsert', $ex->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {

        $data = [
            'title'     => $request->get('title'),
            'sub_title' => $request->get('sub_title'),
            'link'      => $request->get('link'),
            'link_name' => $request->get('link_name'),
        ];

        $image = Slider::find($id)->image;
        if($request->hasFile('image')){
            $data['image'] = imageUpdate($request, 'image', 'slider', 'uploads/images/slider/', $image);
        }

        try {
            Slider::find($id)->update($data);
            Alert::success('Slider Updated', 'Slider Successfully Updated');
            return redirect()->route('slider.index');
        } catch(\Exception $ex) {
            Alert::error('DataInsert', $ex->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        // if ($error = $this->sendPermissionError('delete')) {
        //     return $error;
        // }
        $slider = Slider::find($id);
        $path =  public_path('uploads/images/slider/'.$slider->image);
        if(file_exists($path)){
            unlink($path);
            $slider->delete();
            return redirect()->back();
        }else{
            $slider->delete();
            return redirect()->back();
        }
    }
}
