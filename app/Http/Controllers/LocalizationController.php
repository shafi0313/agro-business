<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function locale(Request $request, $locale)
    {
        session(['APP_LOCALE' => $locale]);
        return redirect()->back();
    }
}
