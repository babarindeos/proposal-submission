<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalApplication extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'user_id', 'call_for_proposal_id', 'proposal_file', 'principal_investigator', 'proposal_title', 'proposal_description', 'status'];



    public function call_for_proposal()
    {
        return $this->belongsTo(CallForProposal::class, 'call_for_proposal_id', 'id');
        
    }

    public function reviews()
    {
        return $this->hasMany(ProposalReviewers::class, 'proposal_application_id', 'id');
    }
}
