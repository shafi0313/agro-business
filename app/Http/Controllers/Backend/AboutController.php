<?php

namespace App\Http\Controllers\Backend;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function edit($id)
    {
        $about = About::find($id);
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'title' => $request->get('title'),
            'texts' => $request->get('texts'),
        ];

        DB::beginTransaction();
        try {
            About::where('id', 1)->update($data);
            DB::commit();
            toast('About Successfully Updated','success');
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'About Update Failed','error');
            return redirect()->back();
        }
    }
}
