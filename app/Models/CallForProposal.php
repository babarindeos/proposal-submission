<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProposalApplication;

class CallForProposal extends Model
{
    use HasFactory;

     protected $fillable = ['uuid', 'title', 'description', 'open_date', 'close_date', 'advert'];


     public function proposal_applications()
     {
        return $this->hasMany(ProposalApplication::class, 'call_for_proposal_id', 'id');
     }


     public function submissions()
     {
         
     }

     public function reviews()
     {
         return $this->hasManyThrough(ProposalReviewers::class, ProposalApplication::class, 
                                          'call_for_proposal_id', 
                                          'proposal_application_id', 
                                          'id', 
                                          'id');
     }

     public function reviewers()
     {
         return $this->hasManyThrough(Reviewer::class, ProposalApplication::class, 
                                          'call_for_proposal_id', 
                                          'id', 
                                          'id', 
                                          'reviewer_id');
     }


     

}
