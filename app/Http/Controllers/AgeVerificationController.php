<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgeVerificationController extends Controller
{
    public function index()
    {
        return view('auth.age-verification');
    }

    public function verify(Request $request)
    {
        if ($request->input('verified') == 1) {
            $request->session()->put('age_verified', true);
            return redirect()->route('home');
        }

        return redirect('https://www.google.com');
    }
}
