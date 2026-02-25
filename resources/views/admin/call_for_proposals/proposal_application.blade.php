<x-admin-layout>

    <div class="flex flex-col border-0 border-red-900 w-full">
        <section class="flex flex-row justify-between border-b border-gray-200 py-2 px-8 md:px-10 mt-6">
                <div class="text-2xl font-semibold ">
                    Call for Proposals
                </div>

                
                
        </section>
       
        
       
    
        <section class="py-8 mt-2">
                <div>
                    <form  action="{{ route('admin.call_for_proposals.proposal_application.status_update',['proposal_application'=>$proposal_application->id]) }} " method="POST" enctype="multipart/form-data" class="flex flex-col mx-auto w-full md:w-[95%] items-center justify-center">
                        @csrf
    
                        
    
                        <div class="flex flex-col w-[80%] md:w-[60%] py-2 md:py-4" style="font-family:'Lato'; font-size:18px; font-weight:400;">
                            <h2 class="font-semibold text-xl py-1" >{{ $call_for_proposal->title }}</h2>
                            
                        </div>
    
    
                        <div class="flex flex-col w-[80%] md:w-[60%]">
                            @include('partials._session_response')

                            {{-- Success Message --}}
                            @if (session('success'))
                                <div class="flex flex-col justify-center items-center mb-4 rounded-md bg-green-100 p-4 text-green-800">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Error Message --}}
                            @if ($errors->any())
                                <div class="flex flex-col justify-center items-center mb-4 rounded-md bg-red-100 p-4 text-red-800">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                        </div>
                        

                      
                            
                        
                        <!-- Principal Investigator //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <input type="text" disabled name="principal_investigator" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Principal Investigator"
                                                                    
                                                                    value="{{ $proposal_application->principal_investigator }}"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    required
                                                                    />  
                                                                                                                                        
    
                                                                    @error('principal_investigator')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Principal Investigator //--> 
    

                        <!-- Title //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <input type="text" disabled name="proposal_title" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Proposal Title"
                                                                    
                                                                    value="{{ $proposal_application->proposal_title }}"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    required
                                                                    />  
                                                                                                                                        
    
                                                                    @error('proposal_title')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Title //--> 
    
                        
                        
    
                       
                        
                        
                        

                         <!-- Proposal file //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-2">
                                                    
                                            <div class='px-1 py-1'>Proposal File</div>
                                            <a type='text' name="proposal_file" class="border border-1 border-gray-400 bg-gray-50
                                                                                    w-full p-4 rounded-md 
                                                                                    focus:outline-none
                                                                                    focus:border-blue-500 
                                                                                    focus:ring
                                                                                    focus:ring-blue-100
                                                                                    hover:underline
                                                                                    text-blue-600
                                                                                    " 
                                            
                                            style="font-family:'Lato';font-size:16px;font-weight:500;"
                                            accept=".docx, .pdf, .doc, .odt"
                                            href="{{ asset('storage/'.$proposal_application->proposal_file) }}"
                                            target="_blank"
                                            required
                                            >{{ $proposal_application->proposal_file }}</a>
                                                
                    
                                            @error('proposal_file')
                                                <span class="text-red-700 text-sm">
                                                    {{$message}}
                                                </span>
                                            @enderror
                                            
                        </div>
                        <!-- end of Proposal file //-->      


                        <!-- Description //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <textarea type="text" disabled name="proposal_description" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Description"
                                                                    
                                                                    rows="5"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    required
                                                                    >{{ $proposal_application->proposal_description }}</textarea> 
                                                                                                                                        
    
                                                                    @error('proposal_description')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Description //--> 


                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3 mt-10">
                            <div class='font-semibold'>Office use only -  Status Update</div>
                        </div>

                        <!-- Status //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <select name="status" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100"                                                           
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    required    
                                                                    >  
                                                                    <option value=''>-- Select Option --</option>
                                                                    <option value='pending' @if ($proposal_application->status == 'pending') selected @endif>Pending</option>
                                                                    <option value='accepted' @if ($proposal_application->status == 'accepted') selected @endif>Accepted</option>
                                                                    <option value='rejected' @if ($proposal_application->status == 'rejected') selected @endif>Rejected</option>
                            </select>
                                                                                                                                        
    
                                                                    @error('status')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Status //--> 


                        <!-- Description //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <textarea type="text" name="remark" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Remark"
                                                                    
                                                                    rows="5"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    required
                                                                    >{{ $proposal_application->remark }}</textarea> 
                                                                                                                                        
    
                                                                    @error('remark')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Description //--> 

    


                                  
    
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] mt-4">
                            <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                           hover:bg-gray-500
                                           rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Submit</button>
                        </div>
                       
                    </form><!-- end of new Application for Call for Proposal form //-->
                <div>
    
            

        </section>
        <!-- End of Create Call for Proposals Section //-->



    </div>

</x-admin-layout>