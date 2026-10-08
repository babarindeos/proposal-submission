<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CallForProposal;
use Illuminate\Support\Str;
use App\Models\ProposalApplication;
use App\Models\ScoringGuide;
use App\Http\Classes\Notifier;
use App\Mail\ApplicationStatusUpdatedMail;

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
            'title' => 'required|unique:call_for_proposals,title',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after:open_date',
            'status' => 'nullable|in:draft,archived',
        ]);


        $uuid = Str::orderedUuid();

        $formFields['uuid'] = $uuid;
        $formFields['title'] = $request->title;
        $formFields['description'] = $request->description;
        $formFields['open_date'] = $request->open_date;
        $formFields['close_date'] = $request->input('close_date');
        // Publishing a call live is the default; admins can save it as a
        // draft (not yet visible to staff) via the status field.
        $formFields['status'] = $request->input('status');
        

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


    /**
     * Ranked results for a call: every application with how many reviewers
     * it was sent to, how many have scored it, and its average score —
     * aggregated from potentially several reviewers' scoring sheets.
     */
    public function results(CallForProposal $call_for_proposal)
    {
        $proposal_applications = ProposalApplication::where('call_for_proposal_id', $call_for_proposal->id)
                                                     ->get()
                                                     ->sortByDesc(fn ($application) => $application->average_score ?? -1)
                                                     ->values();

        $max_obtainable_score = ScoringGuide::sum('mark_obtainable');

        return view('admin.call_for_proposals.results', compact('call_for_proposal', 'proposal_applications', 'max_obtainable_score'));
    }


    public function proposal_application(CallForProposal $call_for_proposal, ProposalApplication $proposal_application)
    {
        return view('admin.call_for_proposals.proposal_application', compact('call_for_proposal', 'proposal_application'));

    }


    public function status_update(Request $request, ProposalApplication $proposal_application)
    {
        $request->validate([
            'status' => 'required|in:pending,acknowledged,accepted,rejected',
            'remark' => 'nullable|string|max:2000',
        ]);

        $previous_status = $proposal_application->status;

        $proposal_application->status = $request->status;
        $proposal_application->remark = $request->remark;
        $proposal_application->save();

        $message = 'Status has been updated successfully.';

        // Tell the applicant when the decision changes. Not for "pending"
        // (that's the starting state). The remark is internal ("office use
        // only") so it is only included if the admin ticked the box.
        if ($previous_status !== $proposal_application->status && $proposal_application->status !== 'pending')
        {
            $proposal_application->load('owner', 'call_for_proposal');

            $sent = Notifier::send(
                $proposal_application->owner->email,
                new ApplicationStatusUpdatedMail($proposal_application, $request->boolean('share_remark')),
                'status update - applicant'
            );

            $message .= $sent
                ? ' The applicant has been notified by email.'
                : ' The applicant could not be notified by email - please let them know directly.';
        }

        return redirect()->back()->with(['error' => true, 'status' => 'success', 'message' => $message]);
    }

    public function edit(CallForProposal $call_for_proposal)
    {
        return view('admin.call_for_proposals.edit', compact('call_for_proposal'));
    }

    public function update(Request $request, CallForProposal $call_for_proposal)
    {
        $request->validate([
            'title' => 'required|unique:call_for_proposals,title,'.$call_for_proposal->id,
            'open_date' => 'required|date',
            'close_date' => 'required|date|after:open_date',
            'status' => 'nullable|in:draft,archived',
        ]);

        $formFields['title'] = $request->title;
        $formFields['description'] = $request->description;
        $formFields['open_date'] = $request->open_date;
        $formFields['close_date'] = $request->input('close_date');
        $formFields['status'] = $request->input('status');
        

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


    public function destroy(CallForProposal $call_for_proposal)
    {
        // Don't allow a call to be deleted once staff have applied — archive
        // it instead so existing submissions and reviews stay intact.
        if ($call_for_proposal->proposal_applications()->exists())
        {
            return redirect()->route('admin.call_for_proposals.index')
                              ->with([
                                  'error' => true,
                                  'status' => 'fail',
                                  'message' => 'This call already has submissions and cannot be deleted. Set its status to Archived instead.'
                              ]);
        }

        $call_for_proposal->delete();

        return redirect()->route('admin.call_for_proposals.index')
                          ->with([
                              'error' => true,
                              'status' => 'success',
                              'message' => 'Call for Proposal has been deleted.'
                          ]);
    }

}
