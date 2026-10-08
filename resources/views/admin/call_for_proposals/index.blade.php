<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[100%] md:w-[100%] py-8 px-4 md:px-0 border-red-900 mx-auto">
        
            <div class="flex flex-col md:flex-row gap-y-2 border-b border-gray-300 py-2 md:justify-between">
                    <div >
                        <h1 class="text-2xl font-semibold font-serif text-gray-800">Call for Proposals</h1>
                    </div>
                    <div>
                            <a href="{{ route('admin.call_for_proposals.create') }}" class="bg-green-600 text-white py-2 px-4 
                                            rounded-lg text-sm hover:bg-green-500">New Call for Proposals</a>
                    </div>
            </div>
        </section>
        <!-- end of page header //-->

        <section class="flex flex-col w-[95%] md:w-[100%] mx-auto px-0 mb-8">
            <table class="table-auto border-collapse border border-1 border-gray-200"  >
                <tr class="bg-gray-200">
                    <td class="text-center font-semibold py-4 w-16">SN</td>
                    <td class="font-semibold py-2">Title</td>
                    <td class="font-semibold py-2">Dates</td>
                    <td class="font-semibold py-2">Status</td>
                    <td class="font-semibold py-2 text-center">Action</td>
                </tr>
                <tbody>
                    @foreach($call_for_proposals as $index => $call_for_proposal)
                        <tr class="border border-1 border-gray-200">
                            <td class="text-center py-8 w-16">{{ $index + 1 }}.</td>
                            <td class="py-8">
                                <a href="{{ route('admin.call_for_proposals.show', $call_for_proposal->id) }}" class="text-blue-600 hover:underline">{{ $call_for_proposal->title }}</a>
                                <div class='text-sm flex flex-row gap-x-5 flex-wrap'>
                                    <div>
                                        <a class="hover:underline" href="{{ route('admin.call_for_proposals.submissions',['call_for_proposal' => $call_for_proposal->id]) }}">Submissions ({{ $call_for_proposal->proposal_applications->count() }})</a>
                                    </div>
                                     <div>
                                        <a class="hover:underline" href="{{ route('admin.call_for_proposals.submissions',['call_for_proposal' => $call_for_proposal->id]) }}">Sent for Review ({{ $call_for_proposal->reviews->count() }})</a>
                                    </div>
                                     <div>
                                        <a class="hover:underline" href="{{ route('admin.call_for_proposals.results',['call_for_proposal' => $call_for_proposal->id]) }}">Results</a>
                                    </div>
                                </div>
                            </td>
                            <td class="py-8">{{ \Carbon\Carbon::parse($call_for_proposal->open_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($call_for_proposal->close_date)->format('M d, Y') }}</td>
                            <td class="py-8">
                                @php $status = $call_for_proposal->computed_status; @endphp
                                <span class="font-semibold @if($status === 'Open') text-green-600 @elseif($status === 'Upcoming') text-blue-600 @else text-gray-500 @endif">{{ $status }}</span>
                            </td>                      
                            <td class="text-center py-2">              
                                <div class="flex flex-row gap-x-1 justify-center">              
                                     <a href="{{ route('admin.call_for_proposals.edit',['call_for_proposal' => $call_for_proposal->id]) }}" class="hover:bg-blue-600 border bg-blue-500 text-white py-2 px-2 text-xs rounded-md">Edit</a> 
                                     <form action="{{ route('admin.call_for_proposals.destroy',['call_for_proposal' => $call_for_proposal->id]) }}" method="POST" onsubmit="return confirm('Delete this call for proposal? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:bg-red-600 border bg-red-500 text-white py-2 px-2 text-xs rounded-md">Delete</button>
                                     </form>
                                </div>                 
                            </td>                      
                        </tr>                  
                    @endforeach                
                </tbody>

            </table>


        </section>
    </div>
</x-admin-layout>