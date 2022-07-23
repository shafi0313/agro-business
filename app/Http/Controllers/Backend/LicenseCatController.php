<?php

namespace App\Http\Controllers\Backend;

use App\Models\LicenseCat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class LicenseCatController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('license-category-manage')) {
            return $error;
        }
        $licenseCats = LicenseCat::all();
        return view('admin.license_cat.index', compact('licenseCats'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('license-category-add')) {
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
            toast($ex->getMessage().'Size Inserted Failed', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('license-category-edit')) {
            return $error;
        }
        $licenseCat = LicenseCat::find($id);
        return view('admin.license_cat.edit', compact('licenseCat'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('license-category-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            LicenseCat::find($id)->update($data);
            toast('Category Successfully Update', 'success');
            return redirect()->route('license-category.index');
        } catch (\Exception $ex) {
            toast('Category Update Failed', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('license-category-delete')) {
            return $error;
        }
        try {
            LicenseCat::find($id)->delete();
            Alert::success(__('app.success'), __('app.delete-success-message'));
            return redirect()->back();
        } catch (\Exception $ex) {
            Alert::error(__('app.oops'), __('app.delete-error-message'));
            return back();
        }
    }
}
