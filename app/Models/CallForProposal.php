<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProposalApplication;

class CallForProposal extends Model
{
    use HasFactory;

     protected $fillable = ['uuid', 'title', 'description', 'open_date', 'close_date', 'advert', 'status'];

     protected $casts = [
        'open_date' => 'date',
        'close_date' => 'date',
     ];

     // Manual statuses an admin can force, on top of the date-driven ones below.
     const STATUS_DRAFT = 'draft';
     const STATUS_ARCHIVED = 'archived';

     /**
      * The call's effective status, derived from its dates unless an admin
      * has manually set it to draft or archived. This replaces the
      * open/closed Carbon::now()->between(...) checks that used to be
      * duplicated across the admin index, staff pages and the homepage.
      */
     public function getComputedStatusAttribute(): string
     {
        if ($this->status === self::STATUS_DRAFT) {
            return 'Draft';
        }

        if ($this->status === self::STATUS_ARCHIVED) {
            return 'Archived';
        }

        $now = now()->startOfDay();

        if ($now->lt($this->open_date)) {
            return 'Upcoming';
        }

        if ($now->gt($this->close_date)) {
            return 'Closed';
        }

        return 'Open';
     }

     /**
      * Whether staff can currently submit an application for this call.
      */
     public function isOpen(): bool
     {
        return $this->computed_status === 'Open';
     }

     public function scopeOpen($query)
     {
        return $query->where(function ($q) {
                        $q->whereNull('status')->orWhereNotIn('status', [self::STATUS_DRAFT, self::STATUS_ARCHIVED]);
                    })
                    ->whereDate('open_date', '<=', now())
                    ->whereDate('close_date', '>=', now());
     }


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


     public function reviewed()
     {
        
     }
     

}
