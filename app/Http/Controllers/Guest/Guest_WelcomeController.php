<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CallForProposal;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class Guest_WelcomeController extends Controller
{
    //
    public function index()
    {   

        $call_for_proposals = CallForProposal::where(function ($q) {
                                                $q->whereNull('status')
                                                  ->orWhereNotIn('status', [CallForProposal::STATUS_DRAFT]);
                                              })
                                              ->orderBy('created_at', 'desc')
                                              ->paginate(3);

        

        return view('welcome', compact('call_for_proposals'));
    }


    /**
     * Full listing of every call for proposals (open, upcoming and closed),
     * separate from the homepage which only teases the 3 most recent.
     */
    public function call_for_proposals()
    {
        $call_for_proposals = CallForProposal::where(function ($q) {
                                                $q->whereNull('status')
                                                  ->orWhereNotIn('status', [CallForProposal::STATUS_DRAFT]);
                                              })
                                              ->orderBy('close_date', 'desc')
                                              ->paginate(10);

        return view('call_for_proposals', compact('call_for_proposals'));
    }


    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
            $formFields = $request->validate([
                'surname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            // Keep the plain-text password: it is emailed to the user below.
            // (Only the hash is stored, so it can't be recovered afterwards.)
            $plain_password = Str::random(10);

            try
            {
                DB::beginTransaction();

                $user = new User();
                $user->surname = $formFields['surname'];
                $user->firstname = $formFields['firstname'];
                $user->middlename = $request->input('middlename');
                $user->email = $formFields['email'];
                $user->password = bcrypt($plain_password);
                $user->role = 'staff';
                $user->save();

                // Unlike other notifications, this email IS the point of
                // registering - it's the only way the person learns their
                // password. If it can't be sent, the account is rolled back
                // so they can simply register again.
                Mail::to($user->email)->send(new NewUserMail([
                    'fullname' => trim($user->firstname.' '.$user->surname),
                    'username' => $user->email,
                    'password' => $plain_password,
                ]));

                DB::commit();

                return redirect()->route('guest.auth.register')->with('success', 'Your login details have been sent to '.$user->email.'. Please check your inbox (and spam folder).');
            }
            catch (\Throwable $e)
            {
                DB::rollBack();
                report($e);

                return back()->withInput()->withErrors(['error' => 'We could not email your login details, so your account was not created. Please try again shortly, or contact DRIP if this keeps happening.']);
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
