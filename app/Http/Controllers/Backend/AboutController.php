<?php

namespace App\Http\Controllers\Backend;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function edit()
    {
        if ($error = $this->authorize('about-edit')) {
            return $error;
        }
        $about = About::find(1);
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('about-edit')) {
            return $error;
        }
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
