<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[95%] md:w-[95%] py-8 px-4 border-red-900 mx-auto">
        
            <div class="flex border-b border-gray-300 py-2 justify-between">
                    <div >
                        <div class="text-lg font-semibold font-serif text-gray-800">Applications</div>
                        <div class="text-xl font-semibold font-serif text-gray-800">{{ $call_for_proposal->title }}</div>
                    </div>
                    <div class="flex gap-x-2">
                            <a href="{{ route('admin.call_for_proposals.results',['call_for_proposal' => $call_for_proposal->id]) }}" class="bg-blue-600 text-white py-2 px-4
                                            rounded-lg text-sm hover:bg-blue-500">View Results</a>
                            <a href="{{ route('admin.call_for_proposals.index') }}" class="bg-green-600 text-white py-2 px-4 
                                            rounded-lg text-sm hover:bg-green-500">Call for Proposals</a>
                    </div>
            </div>
        </section>
        <!-- end of page header //-->

        <section class="flex flex-col w-[95%] md:w-[95%] mx-auto px-4">
            <table class="table-auto border-collapse border border-1 border-gray-200"  >
                <tr class="bg-gray-200">
                    <td width="8%" class="text-center font-semibold py-4">SN</td>
                    <td width="40%" class="font-semibold py-2">Title</td>
                    <td width="25%" class="font-semibold py-2">Principal Investigator (PI)</td>                   
                    <td width="10%" class="font-semibold py-2">Status</td>
                    <td width="12%" class="font-semibold py-2 text-center">Reviewed</td>
                    <td width="10%" class="font-semibold py-2 text-center">Action</td>
                </tr>
                <tbody>
                    @foreach($proposal_applications as $index => $application)
                        <tr class="border border-1 border-gray-200 odd:bg-gray-50 even:bg-white">
                            <td class="text-center py-8 w-16">{{ $index + 1 }}.</td>
                            <td class="py-8 pr-50">
                                <a href="{{ route('admin.call_for_proposals.proposal_application',['call_for_proposal' => $call_for_proposal->id, 'proposal_application' => $application->id ]) }}" class="text-blue-600 hover:underline">{{ $application->proposal_title }}</a>
                                <div class='flex flex-col  gap-x-5 text-sm'>
                                        <div class="md:flex-row flex-col flex gap-y-2 gap-x-5">
                                            <div>
                                                <a class="hover:underline"  href="{{ asset('storage/'.$application->proposal_title_file) }}" 
                                                        target="_blank">Proposal Title</a>
                                            </div>
                                            <div>
                                                <a class="hover:underline"  href="{{ asset('storage/'.$application->proposal_file) }}" 
                                                        target="_blank">Proposal Document</a>
                                            </div>
                                        </div>
                                        <div class='py-2 text-xs'>
                                            <span class='font-semibold'>Applicant: </span> {{ $application->owner->surname }} {{ $application->owner->firstname }}
                                        </div>
                                </div>
                            </td>
                            <td class="py-8">{{ $application->principal_investigator }}</td>
                            <td class="py-8">
                                @if ($application->status == 'pending')
                                    <span class="text-amber-600 font-semibold">Pending</span>
                                @elseif ($application->status == 'acknowledged')
                                    <span class="text-blue-600 font-semibold">Acknowledged</span>
                                @elseif ($application->status == 'accepted')
                                    <span class="text-green-600 font-semibold">Accepted</span> 
                                @elseif ($application->status == 'rejected')
                                    <span class="text-red-600 font-semibold">Rejected</span>                  
                                @endif              
                            </td>                      
                            <td class="text-center py-2 py-8">
                                @if ($application->reviewers_assigned_count > 0)
                                    <span class="@if($application->review_complete) text-green-700 @else text-amber-600 @endif font-semibold text-sm">
                                        {{ $application->reviewers_completed_count }} / {{ $application->reviewers_assigned_count }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">Not sent</span>
                                @endif
                            </td>
                            <td class="text-center py-2">              
                                <div>              
                                     <a href="{{ route('admin.call_for_proposals.proposal_application.send_to_reviewer',['proposal_application'=>$application->id]) }}" class="hover:bg-blue-600 border bg-blue-500 text-white py-2 px-2 text-xs rounded-md">Send to Reviewer</a> 
                                        
                                </div>                 
                            </td>                      
                        </tr>                  
                    @endforeach                
                </tbody>

            </table>


        </section>
    </div>
</x-admin-layout>