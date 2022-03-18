<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function create()
    {
        return view('admin.my_profile.reset_password.create');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'password' => ['required', 'confirmed', Password::min(6)
                                                            ->letters()
                                                            // ->mixedCase()
                                                            ->numbers()
                                                            ->symbols()
                                                            ->uncompromised()],
        ]);

        $userId = Auth::user()->id;
        $old_password = $request->old_password;

        if(Hash::check($old_password, Auth::user()->password)){
            User::find($userId)->update(['password'=>bcrypt($request->password)]);
        }else{
            Alert::error('Old password does not match');
            return back();
        }
    }
}
