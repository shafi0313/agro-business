<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PackSize;
use Illuminate\Http\Request;

class PackSizeController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('pack-size-manage')) {
            return $error;
        }
        $PackSizes = PackSize::all();
        return view('admin.pack_size.index', compact('PackSizes'));
    }

    public function store(Request $request)
    {

        if ($error = $this->authorize('pack-size-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'type' => 'required',
            'size' => 'required',
        ]);

        try {
            PackSize::create($data);
            toast('Size Successfully Inserted', 'success');
            return redirect()->route('pack-size.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Size Inserted Failed', 'error');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        if ($error = $this->authorize('pack-size-edit')) {
            return $error;
        }
        $packSize = PackSize::find($id);
        return view('admin.pack_size.edit', compact('packSize'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('pack-size-edit')) {
            return $error;
        }
        $data = [
            'type' => $request->get('type'),
            'size' => $request->get('size'),
        ];

        try {
            PackSize::find($id)->update($data);
            toast('Size Successfully Update', 'success');
            return redirect()->route('pack-size.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Size Update Failed', 'error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($error = $this->authorize('pack-size-delete')) {
            return $error;
        }
        PackSize::find($id)->delete();
        toast('Size Successfully Deleted', 'success');
        return redirect()->back();
    }
}
