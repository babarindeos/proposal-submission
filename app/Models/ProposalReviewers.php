<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalReviewers extends Model
{
    use HasFactory;

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'reviewer_id', 'id');
    }

    public function proposal_application()
    {
        return $this->belongsTo(ProposalApplication::class, 'proposal_application_id', 'id');
    }
}
