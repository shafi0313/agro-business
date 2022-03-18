<?php

namespace App\Http\Controllers\Backend;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CompanyInfoController extends Controller
{
    public function adminIndex()
    {
        $data = CompanyInfo::whereId(1)->first();
        return view('admin.company_info.admin', compact('data'));
    }
    public function adminUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|max:191',
            'email' => 'sometimes|max:191',
            'address' => 'required|max:255',
        ]);

        if($request->hasFile('logo')){
            $file = CompanyInfo::where('id', 1)->first(['logo']);
            $path =  public_path('/files/images/icon/'.$file->logo);
            file_exists($path)?unlink($path):false;

            $image = $request->file('logo');
            $imageName = "admin_logo".rand(0, 100).'.'.$image->getClientOriginalExtension();
            $path = public_path().'/files/images/icon';
            if(!file_exists($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $request->logo->move('files/images/icon/', $imageName);
            $data['logo'] = $imageName;
        }

        if($request->hasFile('favicon')){
            $file = CompanyInfo::where('id', 1)->first(['favicon']);
            $path =  public_path('/files/images/icon/'.$file->favicon);
            file_exists($path)?unlink($path):false;

            $image = $request->file('favicon');
            $imageName = "admin_favicon".rand(0, 100).'.'.$image->getClientOriginalExtension();
            $path = public_path().'/files/images/icon';
            if(!file_exists($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $request->favicon->move('files/images/icon/', $imageName);
            $data['favicon'] = $imageName;
        }

        try {
            CompanyInfo::whereId(1)->update($data);
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }

    public function frontIndex()
    {
        $data = CompanyInfo::whereId(2)->first();
        return view('admin.company_info.front', compact('data'));
    }
    public function frontUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|max:191',
            'email' => 'sometimes|max:191',
            'address' => 'required|max:255',
        ]);

        if($request->hasFile('logo')){
            $file = CompanyInfo::where('id', 1)->first(['logo']);
            $path =  public_path('/files/images/icon/'.$file->logo);
            file_exists($path)?unlink($path):false;

            $image = $request->file('logo');
            $imageName = "admin_logo".rand(0, 100).'.'.$image->getClientOriginalExtension();
            $path = public_path().'/files/images/icon';
            if(!file_exists($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $request->logo->move('files/images/icon/', $imageName);
            $data['logo'] = $imageName;
        }

        if($request->hasFile('favicon')){
            $file = CompanyInfo::where('id', 1)->first(['favicon']);
            $path =  public_path('/files/images/icon/'.$file->favicon);
            file_exists($path)?unlink($path):false;

            $image = $request->file('favicon');
            $imageName = "admin_favicon".rand(0, 100).'.'.$image->getClientOriginalExtension();
            $path = public_path().'/files/images/icon';
            if(!file_exists($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $request->favicon->move('files/images/icon/', $imageName);
            $data['favicon'] = $imageName;
        }

        try {
            CompanyInfo::whereId(1)->update($data);
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');
            return redirect()->back();
        }
    }
}
