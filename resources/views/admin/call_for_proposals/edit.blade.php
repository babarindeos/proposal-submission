<x-admin-layout>

    <div class="flex flex-col border-0 border-red-900 w-full">
        <section class="flex flex-row justify-between border-b border-gray-200 py-2 px-8 md:px-10 mt-6">
                <div class="text-2xl font-semibold ">
                    Call for Proposals
                </div>

                <div>                          


                            <a href="{{ route('admin.call_for_proposals.index') }}" class="border border-green-600 text-green-600 py-2 px-6 
                                            rounded-lg text-xs md:text-sm hover:bg-green-500 hover:text-white hover:border-green-500">Call for Proposals</a>
                </div>
                
        </section>
       
        
       
    
        <section class="py-8 mt-2">
                <div>
                    <form  action="{{ route('admin.call_for_proposals.update',['call_for_proposal' => $call_for_proposal->id]) }} " method="POST" enctype="multipart/form-data" class="flex flex-col mx-auto w-full md:w-[95%] items-center justify-center">
                        @csrf
    
                        
    
                        <div class="flex flex-col w-[80%] md:w-[60%] py-2 md:py-4" style="font-family:'Lato'; font-size:18px; font-weight:400;">
                            <h2 class="font-semibold text-xl py-1" >Edit Call for Proposals</h2>
                            
                        </div>
    
    
                        <div class="flex flex-col w-[80%] md:w-[60%]">
                            @include('partials._session_response')
                        </div>
                        

                        <!-- Title //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <input type="text" name="title" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Title"
                                                                    
                                                                    value="{{ $call_for_proposal->title ?? old('title') }}"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    
                                                                    />  
                                                                                                                                        
    
                                                                    @error('title')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Title //--> 
    
                        
                        
    
                       
                        
                        <!-- Open Date and Close Date //-->
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 border-red-900 w-[80%] md:w-[60%] py-3">
                                
                                    <!-- Open Date //-->
                                    <div class="flex flex-col md:w-3/5">
                                                <input type="date" name="open_date" class="border border-1 border-gray-400 bg-gray-50
                                                                                        w-full p-4 rounded-md 
                                                                                        focus:outline-none
                                                                                        focus:border-blue-500 
                                                                                        focus:ring
                                                                                        focus:ring-blue-100" placeholder="Open Date"
                                                                                        
                                                                                        value="{{ $call_for_proposal->open_date ?? old('open_date') }}"
                                                                                        
                                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                                        required
                                                                                        />  
                                                                                        <div>                                                                              
                                                                                                <div class="text-sm">
                                                                                                        Open Date
                                                                                                </div>
                                                                                                <div>                                                                                                
                                                                                                        @error('open_date')
                                                                                                            <span class="text-red-700 text-sm">
                                                                                                                {{$message}}
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                </div>
                                                                                        </div>
                                    </div>
                                    <!-- End Open Date //-->



                                    <!-- Close Date //-->
                                    <div class="flex flex-col md:w-3/5">
                                                <input type="date" name="close_date" class="border border-1 border-gray-400 bg-gray-50
                                                                                        w-full p-4 rounded-md 
                                                                                        focus:outline-none
                                                                                        focus:border-blue-500 
                                                                                        focus:ring
                                                                                        focus:ring-blue-100" placeholder="Close Date"
                                                                                        
                                                                                        value="{{ $call_for_proposal->close_date ?? old('close_date') }}"
                                                                                        
                                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                                        required
                                                                                        />  
                                                                                        <div>                                                                              
                                                                                                <div class="text-sm">
                                                                                                        Close Date
                                                                                                </div>
                                                                                                <div>                                                                                                
                                                                                                        @error('close_date')
                                                                                                            <span class="text-red-700 text-sm">
                                                                                                                {{$message}}
                                                                                                            </span>
                                                                                                        @enderror
                                                                                                </div>
                                                                                        </div>
                                    </div>
                                    <!-- End Date //-->

                            
                                        
                        </div><!-- end of Start Date and End Date //-->
                        
                        

                         <!-- Photo file //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-2">
                                                    
                                            <div class='px-1 py-1'>Photo</div>
                                            <input type="file" name="advert" class="border border-1 border-gray-400 bg-gray-50
                                                                                    w-full p-4 rounded-md 
                                                                                    focus:outline-none
                                                                                    focus:border-blue-500 
                                                                                    focus:ring
                                                                                    focus:ring-blue-100" 
                                            
                                            style="font-family:'Lato';font-size:16px;font-weight:500;"
                                            accept=".jpg, .jpeg, .png"
                                            />
                                            <span class='text-xs py-1'><a target='_blank' href="{{ asset('storage/'.$call_for_proposal->advert) }}">{{ $call_for_proposal->advert }}</a></span>
                                                
                    
                                            @error('advert')
                                                <span class="text-red-700 text-sm">
                                                    {{$message}}
                                                </span>
                                            @enderror
                                            
                        </div>
                        <!-- end of Photo file //-->      


                        <!-- Description //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <textarea type="text" name="description" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Description"
                                                                    
                                                                    rows="5"
                                                                    
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    
                                                                    >{{ $call_for_proposal->description ?? old('description') }}</textarea> 
                                                                                                                                        
    
                                                                    @error('description')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Description //--> 



                                  
    
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] mt-4">
                            <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                           hover:bg-gray-500
                                           rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Update</button>
                        </div>
                        
                    </form><!-- end of new Call for Proposal form //-->
                <div>
    
            

        </section>
        <!-- End of Create Call for Proposals Section //-->



    </div>

</x-admin-layout>