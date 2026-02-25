<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workflow;
use App\Models\PrivateMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\CallForProposal;
//use Illuminate\Support\Facades\Auth;

class Staff_DashboardController extends Controller
{

    public function __construct()
    {
        // check if the user profile has been filled
        //dd(Auth::check());
       
    }

    //
    public function index()
    {
        
        $profileExists = Profile::where('user_id', Auth::user()->id)->exists();

        // if user profile does not exist, create it
        if (!$profileExists)
        {
            return redirect()->route('staff.profile.create');
        }

        /*  $call_for_proposals = CallForProposal::where('open_date', '<=', now())
                                            ->where('close_date', '>=', now())
                                            ->orderBy('created_at', 'asc')
                                            ->get(); */
            $call_for_proposals = CallForProposal::latest()->take(5)->get();

            
        
        
        return view('staff.dashboard', compact('call_for_proposals'));

    }
}
