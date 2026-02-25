<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CallForProposal;
use App\Models\User;
use Illuminate\Support\Str;

class Guest_WelcomeController extends Controller
{
    //
    public function index()
    {   

        $call_for_proposals = CallForProposal::where('open_date', '<=', now())
                                            ->where('close_date', '>=', now())
                                            ->orderBy('created_at', 'asc')
                                            ->get();

        return view('welcome', compact('call_for_proposals'));
    }


    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
            // Registration logic will go here
            $formFields = $request->validate([
                'surname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            $formFields['middlename'] = $request->input('middlename');
            $formFields['password'] =  bcrypt(Str::substr(Str::uuid(), 0,6));


            try
            {
                $user = new User();
                $user->surname = $formFields['surname'];
                $user->firstname = $formFields['firstname'];
                $user->middlename = $formFields['middlename'];
                $user->email = $formFields['email'];
                $user->password = $formFields['password'];
                $user->role = 'staff';
                $user->save();

                // Optionally, you can log the user in immediately after registration
                // Auth::login($user);



                return redirect()->route('guest.auth.register')->with('success', 'Your login credentials has been sent to your email');
            }
            catch (\Exception $e)
            {
                return back()->withErrors(['error' => 'An error occurred. Please try again.']);
            }

            
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
