<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProposalReviewers;
use App\Models\ScoringGuide;
use App\Models\ScoringSheet;
use Illuminate\Support\Str;
use App\Models\Reviewer;
use App\Http\Classes\Notifier;
use App\Mail\ReviewsCompleteAdminMail;

class Guest_CallForProposalController extends Controller
{
    //
    public function get_review($call_for_proposal, $proposal_application, $reviewer, $review)
    {

        //dd($review);
        $proposal_reviewer = ProposalReviewers::where('uuid', $review)
                                    ->where('proposal_application_uuid', $proposal_application)
                                    ->where('reviewer_uuid', $reviewer)
                                    ->first();
        //dd($proposal_reviewer->proposal_application);
        
        $scoring_guides = ScoringGuide::orderBy('section', 'asc')
                                        ->get()
                                        ->groupBy('section');

        $reviewer = Reviewer::where('uuid', $reviewer)
                                    ->first();
        
        //dd($reviewer);
        
       

        // check if the reviewer has already submitted a review for the proposal application
        $already_reviewed = ScoringSheet::where('proposal_reviewers_id', $proposal_reviewer->id)                                        
                                        ->where('reviewer_uuid', $reviewer->uuid)
                                        ->exists();
       

       

        return view('proposal_application_review', compact('proposal_reviewer', 'scoring_guides', 'call_for_proposal', 'proposal_application', 'reviewer', 'review'))->with(['already_reviewed' => $already_reviewed]);

    }

    public function post_review(Request $request, $call_for_proposal, $proposal_application, $reviewer, $review)
    {
        $scoring_guides = ScoringGuide::orderBy('section', 'asc')
                                        ->get()
                                        ->groupBy('section');

        // check if input scores are not greater than the mark obtainable for each scoring guide
        foreach($scoring_guides as $section => $guides){
            foreach($guides as $guide){
                $score = $request->input('scoring_guide_'.$guide->id);
                if($score > $guide->mark_obtainable){
                    return redirect()->back()->withInput()->with('error', 'Score for Section '.$guide->section.' No. '.$guide->sn.' cannot be greater than '.$guide->mark_obtainable);
                }
            }
        }

        $reviewer = Reviewer::find($reviewer);

        $review = ProposalReviewers::where('uuid', $review)
                                    ->first();

        $review_already_done = ScoringSheet::where('proposal_reviewers_id', $review->id)
                                        ->where('reviewer_uuid', $reviewer->uuid)
                                        ->exists();

        if ($review_already_done){
            return redirect()->route('guests.call_for_proposals.proposal_applications.review',['call_for_proposal' => $call_for_proposal, 'proposal_application' => $proposal_application, 'reviewer' => $reviewer->uuid, 'review'=>$review->uuid])
                              ->with('error', 'You have already submitted a review for this proposal — it cannot be submitted again.');
        }

        $scoring_sheet = new ScoringSheet();
        $scoring_sheet->uuid = Str::uuid();
        $scoring_sheet->proposal_reviewers_id =  $review->id;
        $scoring_sheet->proposal_reviewers_uuid =  $review->uuid;
        $scoring_sheet->proposal_application_uuid =  $proposal_application;
        $scoring_sheet->reviewer_uuid =  $reviewer->uuid; 
        $scoring_sheet->reviewer_id =  $reviewer->id;
        foreach($scoring_guides as $section => $guides){
            foreach($guides as $guide){
                $score = $request->input('scoring_guide_'.$guide->id);
                $scoring_sheet->{'scoring_guide_'.$guide->id} = $score;
            }
        }
        $scoring_sheet->comment = $request->input('comment');
        $scoring_sheet->save();

        // Once the last assigned reviewer has submitted, tell DRIP the
        // proposal is ready for a decision. Never blocks the reviewer.
        $application = $review->proposal_application;

        if ($application && $application->review_complete)
        {
            $admin_recipients = Notifier::admin_recipients();

            if (!empty($admin_recipients))
            {
                $application->load('owner', 'call_for_proposal');
                Notifier::send($admin_recipients, new ReviewsCompleteAdminMail($application), 'all reviews complete - admin alert');
            }
        }

        return redirect()->route('guests.call_for_proposals.proposal_applications.review',['call_for_proposal' => $call_for_proposal, 'proposal_application' => $proposal_application, 'reviewer' => $reviewer->uuid, 'review'=>$review->uuid])->with('success', 'Review submitted successfully!'); 
    }
}
