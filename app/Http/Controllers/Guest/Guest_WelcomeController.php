<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guest_WelcomeController extends Controller
{
    //
    public function index()
    {
        return view('welcome');
    }


    public function check_auth()
    {
        if(Auth::check())
        {
            $role = (auth()->user()->role);

            if ($role=='admin')
            {
                return redirect()->route('admin.dashboard.index');
            }
            else
            {
                return redirect()->route('staff.dashboard.index');
            }
            
        }
        else
        {
            return redirect()->route('welcome');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('welcome');
    }


}
