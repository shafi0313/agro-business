<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LicenseCat;
use Illuminate\Http\Request;

class LicenseCatController extends Controller
{
    public function index()
    {
        $licenseCats = LicenseCat::all();
        return view('admin.license_cat.index', compact('licenseCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
            'info' => 'sometimes',
        ]);

        try {
            LicenseCat::create($data);
            toast('Size Successfully Inserted', 'success');
            return redirect()->route('license-category.index');
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Size Inserted Faild', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $licenseCat = licenseCat::find($id);
        return view('admin.license_cat.edit', compact('licenseCat'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            licenseCat::find($id)->update($data);
            toast('Category Successfully Update', 'success');
            return redirect()->route('license-category.index');
        } catch (\Exception $ex) {
            toast('Category Update Failed', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        licenseCat::find($id)->delete();
        toast('Successfully Deleted', 'success');
        return redirect()->back();
    }
}
