<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reviewer;
use Illuminate\Support\str;

class Admin_ReviewerController extends Controller
{
    //
    public function index()
    {
        $reviewers = Reviewer::orderBy('created_at', 'desc')->get();
        return view('admin.reviewers.index', compact('reviewers'));
    }


    public function create()
    {
        return view('admin.reviewers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'expertise_area' => 'required',
            'email' => 'required|email'
        ]);

        try
        {

            $uuid = Str::orderedUuid();

        
            $reviewer = new Reviewer();
            $reviewer->uuid = $uuid;
            $reviewer->name = $request->name;
            $reviewer->expertise_area = $request->expertise_area;
            $reviewer->email = $request->email;
            $reviewer->save();


            $data = [
                'error' => true,
                'status' => 'success',
                'message' => 'The Reviewer has been successfully created'
            ];
        }
        catch(\Exception $e)
        {
            $data = [
                'error' => true,
                'status' => 'fail',
                'message' => 'An error occurred creating the revewer'
            ];

        }

        return redirect()->back()->with($data);
    }
}
