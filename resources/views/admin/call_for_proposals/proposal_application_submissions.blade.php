<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[95%] md:w-[95%] py-8 px-4 border-red-900 mx-auto">
        
            <div class="flex border-b border-gray-300 py-2 justify-between">
                    <div >
                        <h1 class="text-2xl font-semibold font-serif text-gray-800">Applications</h1>
                    </div>
                    <div>
                            <a href="{{ route('admin.call_for_proposals.index') }}" class="bg-green-600 text-white py-2 px-4 
                                            rounded-lg text-sm hover:bg-green-500">Call for Proposals</a>
                    </div>
            </div>
        </section>
        <!-- end of page header //-->

        <section class="flex flex-col w-[95%] md:w-[95%] mx-auto px-4">
            <table class="table-auto border-collapse border border-1 border-gray-200"  >
                <tr class="bg-gray-200">
                    <td class="text-center font-semibold py-4 w-16">SN</td>
                    <td class="font-semibold py-2">Title</td>
                    <td class="font-semibold py-2">Principal Investigator (PI)</td>
                    <td class="font-semibold py-2">Status</td>
                    <td class="font-semibold py-2 text-center">Action</td>
                </tr>
                <tbody>
                    @foreach($proposal_applications as $index => $application)
                        <tr class="border border-1 border-gray-200">
                            <td class="text-center py-8 w-16">{{ $index + 1 }}.</td>
                            <td class="py-8">
                                <a href="{{ route('admin.call_for_proposals.proposal_application',['call_for_proposal' => $call_for_proposal->id, 'proposal_application' => $application->id ]) }}" class="text-blue-600 hover:underline">{{ $application->proposal_title }}</a>
                                <div class='text-sm'>
                                    <a class="hover:underline"  href="{{ asset('storage/'.$application->proposal_file) }}" 
                                                    target="_blank">Proposal document</a>
                                </div>
                            </td>
                            <td class="py-8">{{ $application->principal_investigator }}</td>
                            <td class="py-8">
                                @if ($application->status == 'pending')
                                    <span class="text-amber-600 font-semibold">Pending</span>
                                @elseif ($application->status == 'accepted')
                                    <span class="text-green-600 font-semibold">Accepted</span> 
                                @elseif ($application->status == 'rejected')
                                    <span class="text-red-600 font-semibold">Rejected</span>                  
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