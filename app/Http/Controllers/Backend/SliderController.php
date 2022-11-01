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

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = "slider_".rand(0,1000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/slider/',$image_name);
        }
        $user = auth()->user()->id;
        $data = [
            'user_id' => $user,
            'title' => $request->get('title'),
            'sub_title' => $request->get('sub_title'),
            'link' => $request->get('link'),
            'link_name' => $request->get('link_name'),
            'image' => $image_name,
        ];

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
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = "slider_".rand(0,1000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/slider/',$image_name);
        }else{
            $image_name = $request->get('old_image');
        }
;
        $data = [
            'title' => $request->get('title'),
            'sub_title' => $request->get('sub_title'),
            'link' => $request->get('link'),
            'link_name' => $request->get('link_name'),
            'image' => $image_name,
        ];

        try {
            $update  = Slider::find($id);
            $update->update($data);
            Alert::success('Slider Updated', 'Slider Successfully Updated');
            return redirect()->route('slider.index');
        } catch(\Exception $ex) {
            Alert::error('DataInsert', $ex->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
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
