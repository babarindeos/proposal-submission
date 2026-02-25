<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CallForProposal;
use Illuminate\Support\Str;
use App\Models\ProposalApplication;

class Admin_CallForProposalController extends Controller
{
    //
    public function index()
    {
        $call_for_proposals = CallForProposal::orderBy('created_at', 'desc')->get();

        return view('admin.call_for_proposals.index', compact('call_for_proposals'));
    }

    public function create()
    {
        return view('admin.call_for_proposals.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'open_date' => 'required|date',
            'close_date' => 'required|date'
        ]);


        $uuid = Str::orderedUuid();

        $formFields['uuid'] = $uuid;
        $formFields['title'] = $request->title;
        $formFields['description'] = $request->description;
        $formFields['open_date'] = $request->open_date;
        $formFields['close_date'] = $request->input('close_date');
        

        if ($request->hasFile('advert'))
        {
            $advertFile = $request->file('advert');

            $new_advert_filename = $uuid.".".$advertFile->getClientOriginalExtension();

            $advertFile->storeAs('adverts', $new_advert_filename);

            $formFields['advert'] = "adverts/".$new_advert_filename;
        }


        
        try
        {
             $create = CallForProposal::create($formFields);

             if ($create)
             {
                    $data = [
                        'error' => true,
                        'status' => 'success',
                        'message' => 'Call for Proposal has been successfully created'
                    ];
             }
             else
             {
                     $data = [
                        'error' => true,
                        'status' => 'fail',
                        'message' => 'An error occurred creating the Call for Proposal'
                    ];
             }
        }
        catch(\Exception $e)
        {
                    $data = [
                        'error' => true,
                        'status' => 'fail',
                        'message' => $e->getMessage()
                    ];
        }


        return redirect()->back()->with($data);
    
    }

    public function show(CallForProposal $call_for_proposal)
    {
        return view('admin.call_for_proposals.show', compact('call_for_proposal'));
    }


    public function submissions(CallForProposal $call_for_proposal)
    {
        $proposal_applications = ProposalApplication::where('call_for_proposal_id', $call_for_proposal->id)
                                                     ->orderBy('created_at', 'desc')
                                                     ->get();
        return view('admin.call_for_proposals.proposal_application_submissions', compact('call_for_proposal', 'proposal_applications') );
    }


    public function proposal_application(CallForProposal $call_for_proposal, ProposalApplication $proposal_application)
    {
        return view('admin.call_for_proposals.proposal_application', compact('call_for_proposal', 'proposal_application'));

    }


    public function status_update(Request $request, ProposalApplication $proposal_application)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);


        

        $proposal_application->status = $request->status;
        $proposal_application->remark = $request->remark;
        $proposal_application->save();


        return redirect()->back();
    }

    public function edit(CallForProposal $call_for_proposal)
    {
        return view('admin.call_for_proposals.edit', compact('call_for_proposal'));
    }

    public function update(Request $request, CallForProposal $call_for_proposal)
    {
        $request->validate([
            'title' => 'required',
            'open_date' => 'required|date',
            'close_date' => 'required|date'
        ]);

        $formFields['title'] = $request->title;
        $formFields['description'] = $request->description;
        $formFields['open_date'] = $request->open_date;
        $formFields['close_date'] = $request->input('close_date');
        

        if ($request->hasFile('advert'))
        {
            $advertFile = $request->file('advert');

            $new_advert_filename = $call_for_proposal->uuid.".".$advertFile->getClientOriginalExtension();

            $advertFile->storeAs('adverts', $new_advert_filename);

            $formFields['advert'] = "adverts/".$new_advert_filename;
        }
        else
        {
            $formFields['advert'] = $call_for_proposal->advert;
        }

        try
        {
             $update = $call_for_proposal->update($formFields);

             if ($update)
             {
                    $data = [
                        'error' => true,
                        'status' => 'success',
                        'message' => 'Call for Proposal has been successfully updated'
                    ];
             }
             else
             {
                     $data = [
                        'error' => true,
                        'status' => 'fail',
                        'message' => 'An error occurred updating the Call for Proposal'
                    ];
             }
        }
        catch(\Exception $e)
        {
                    $data = [
                        'error' => true,
                        'status' => 'fail',
                        'message' => $e->getMessage()
                    ];
        }

        return redirect()->back()->with($data);
    }
   
}
