<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[95%] md:w-[95%] py-8 px-4 border-red-900 mx-auto">
        
            <div class="flex border-b border-gray-300 py-2 justify-between">
                    <div >
                        <h1 class="text-2xl font-semibold font-serif text-gray-800">Reviwers</h1>
                    </div>
                    <div>
                            <a href="{{ route('admin.reviewers.create') }}" class="bg-green-600 text-white py-2 px-4 
                                            rounded-lg text-sm hover:bg-green-500">New Reviewer</a>
                    </div>
            </div>
        </section>
        <!-- end of page header //-->

        <section class="flex flex-col w-[95%] md:w-[95%] mx-auto px-4">
            <table class="table-auto border-collapse border border-1 border-gray-200"  >
                <tr class="bg-gray-200">
                    <td class="text-center font-semibold py-4 w-16">SN</td>
                    <td class="font-semibold py-2">Name</td>
                    <td class="font-semibold py-2">Expertise</td>
                    <td class="font-semibold py-2">Email</td>
                    <td class="font-semibold py-2 text-center">Action</td>
                </tr>
                <tbody>
                    @foreach($reviewers as $index => $reviewer)
                        <tr class="border border-1 border-gray-200">
                            <td class="text-center py-8 w-16">{{ $index + 1 }}.</td>
                            <td class="py-8">
                                <a href="#" class="text-blue-600 hover:underline">{{ $reviewer->name }}</a>
                               
                            </td>
                            <td class="py-8">{{ $reviewer->expertise_area}}</td>
                            <td class="py-8">
                                {{ $reviewer->email }}        
                            </td>                      
                            <td class="text-center py-2">              
                                <div>              
                                     <a href="#" class="hover:bg-blue-600 border bg-blue-500 text-white py-2 px-2 text-xs rounded-md">Edit</a> 
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