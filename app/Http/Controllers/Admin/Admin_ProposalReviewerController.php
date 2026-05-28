<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProposalApplication;

use App\Models\Reviewer;
use App\Models\ProposalReviewers;
use Illuminate\Support\Str;

class Admin_ProposalReviewerController extends Controller
{
    //
    public function send_to_reviewer(ProposalApplication $proposal_application)
    {
        $reviewers = Reviewer::orderBy('created_at', 'asc')->get();

        return view('admin.proposal_reviewers.send_to_reviewer', compact('proposal_application', 'reviewers'));
    }

    public function post_send_to_reviewer(Request $request, ProposalApplication $proposal_application)
    {

        //dd($proposal_application);
        //dd($request);

        $reviewer = Reviewer::where('id', $request->reviewer_id)->first();

        //dd($reviewer);
        
        try
        {
            $proposal_reviewer = new ProposalReviewers();
            $proposal_reviewer->uuid = Str::orderedUuid();
            $proposal_reviewer->proposal_application_id = $proposal_application->id;
            $proposal_reviewer->proposal_application_uuid = $proposal_application->uuid;
            $proposal_reviewer->proposal_application_id = $proposal_application->id;
            $proposal_reviewer->reviewer_id = $reviewer->id;
            $proposal_reviewer->reviewer_uuid = $reviewer->uuid;
            $proposal_reviewer->save();

            $data = [
                'error' => true,
                'status' => 'success',
                'message' => 'The proposal has been sent to the Reviewer'
            ];

            $base_url = url('http://127.0.0.1:8000/');
            $call_for_proposal = $proposal_application->call_for_proposal->uuid;
            $proposal_application = $proposal_application->uuid;
            $reviewer = $reviewer->uuid;
            $review = $proposal_reviewer->uuid;

            $link = $base_url.'call_for_proposals/'.$call_for_proposal.'/proposal_applications/'.$proposal_application.'/reviewers/'.$reviewer.'/reviews/'.$review.'/review';
            //$review = 
            //$link = call_for_proposals/{call_for_proposal}/proposal_applications/{proposal_application}/reviewers/{reviewer}/reviews/{review}/review


        }
        catch(\Exception $e)
        {
            $data = [
                'error' => true,
                'status' => 'fail',
                'message' => 'An error occurred sending the proposal to the Reviewer'
            ];
        }

        return redirect()->back()->with($data);
    }   
}
