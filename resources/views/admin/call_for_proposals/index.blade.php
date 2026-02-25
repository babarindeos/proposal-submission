<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[95%] md:w-[95%] py-8 px-4 border-red-900 mx-auto">
        
            <div class="flex border-b border-gray-300 py-2 justify-between">
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

        <section class="flex flex-col w-[95%] md:w-[95%] mx-auto px-4">
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
                                <div class='text-sm flex flex-row gap-x-5'>
                                    <div>
                                        <a class="hover:underline" href="{{ route('admin.call_for_proposals.submissions',['call_for_proposal' => $call_for_proposal->id]) }}">Submissions ({{ $call_for_proposal->proposal_applications->count() }})</a>
                                    </div>
                                     <div>
                                        <a class="hover:underline" href="">Reviews ({{ $call_for_proposal->reviews->count() }})</a>
                                    </div>
                                     <div>
                                        <a class="hover:underline" href="">Reviewed ()</a>
                                    </div>
                                </div>
                            </td>
                            <td class="py-8">{{ \Carbon\Carbon::parse($call_for_proposal->open_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($call_for_proposal->close_date)->format('M d, Y') }}</td>
                            <td class="py-8">
                                @if (\Carbon\Carbon::now()->between(\Carbon\Carbon::parse($call_for_proposal->open_date), \Carbon\Carbon::parse($call_for_proposal->close_date)))
                                    <span class="text-green-600 font-semibold">Open</span>
                                @else
                                    <span class="text-red-600 font-semibold">Closed</span>                  
                                @endif              
                            </td>                      
                            <td class="text-center py-2">              
                                <div>              
                                     <a href="{{ route('admin.call_for_proposals.edit',['call_for_proposal' => $call_for_proposal->id]) }}" class="hover:bg-blue-600 border bg-blue-500 text-white py-2 px-2 text-xs rounded-md">Edit</a> 
                                     <a href="#" class="hover:bg-red-600 border bg-red-500 text-white py-2 px-2 text-xs rounded-md">Delete</a>    
                                </div>                 
                            </td>                      
                        </tr>                  
                    @endforeach                
                </tbody>

            </table>


        </section>
    </div>
</x-admin-layout>