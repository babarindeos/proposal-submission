<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CallForProposal;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ProposalApplication; 

class Staff_ProposalApplicationController extends Controller
{
    //
    public function application($uuid)
    {
        $call_for_proposal = CallForProposal::where('uuid', $uuid)->firstOrFail();

        $has_submitted_application = ProposalApplication::where('user_id', Auth::id())
                                                ->where('call_for_proposal_id', $call_for_proposal->id)
                                                ->exists();

        return view('staff.proposals.application', compact('call_for_proposal', 'has_submitted_application'));
    }

    public function store_application(Request $request, $uuid)
    {
        try
        {
                $call_for_proposal = CallForProposal::where('uuid', $uuid)->firstOrFail();

                // validate the application form fields
                $request->validate([
                    'principal_investigator' => 'required|string|max:255',
                    'proposal_title' => 'required|string|max:255',
                    'proposal_file' => 'required|file|mimes:doc,docx,pdf,odt|max:20480', // max file size of 20MB
                    'proposal_description' => 'required|string|max:5000'
                ]);

                // handle the uploaded proposal file
                if ($request->hasFile('proposal_file'))
                {
                    $proposalFile = $request->file('proposal_file');

                    $new_proposal_filename = $uuid."_".auth()->user()->id."_".time().".".$proposalFile->getClientOriginalExtension();

                    $proposalFile->storeAs('proposals', $new_proposal_filename);

                
                }


                // save the proposal application details to the database
                    // you can create a ProposalApplication model and save the details there
                    // for example:
                    
                    ProposalApplication::create([
                        'uuid' => Str::orderedUuid(),
                        'user_id' => Auth::id(),
                        'call_for_proposal_id' => $call_for_proposal->id,
                        'proposal_file' => "proposals/".$new_proposal_filename,
                        'principal_investigator' => $request->principal_investigator,
                        'proposal_title' => $request->proposal_title,   
                        'proposal_description' => $request->proposal_description
                    ]);
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
                    

        return redirect()->route('staff.call_for_proposals.application', ['uuid' => $uuid])->with('success', 'Your proposal application has been submitted successfully.');
    }
}
