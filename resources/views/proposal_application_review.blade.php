<x-guest-layout>

    <div class="flex flex-col border-0 border-red-900 w-full">
        <section class="flex flex-row justify-between border-b border-gray-200 py-2 px-8 md:px-10 mt-6">
                <div class="text-2xl font-semibold ">
                    REVIEW OF PROPOSALS
                </div>               
                
        </section>
       
        
       
        @if($already_reviewed == false)
                <section class="py-8 mt-2  w-[90%] md:w-[60%] mx-auto"">
                        <div>
                            <form  action="{{ route('guests.call_for_proposals.proposal_applications.review.store',['call_for_proposal' => $call_for_proposal, 'proposal_application' => $proposal_application, 'reviewer' => $reviewer, 'review'=>$review]) }} " method="POST" enctype="multipart/form-data" class="flex flex-col mx-auto w-full md:w-[95%] items-center justify-center">
                                @csrf
            
                                
            
                                <div class="flex flex-col w-[90%] md:w-[60%] py-2 md:py-4" style="font-family:'Lato'; font-size:18px; font-weight:400;">
                                    <h2 class="font-semibold text-xl py-1 text-center" >CRITERIA FOR REVIEW OF PROPOSALS</h2>

                                    
                                </div>
                                <div class='border w-full py-4 px-4 rounded-md mb-4 border-green-600'>
                                    <div><span class='font-semibold'>Proposal:</span> {{ $proposal_reviewer->proposal_application->proposal_title }}</div>
                                    <div><span class='font-semibold'>Document:</span> <a href="{{ asset('storage/'.$proposal_reviewer->proposal_application->proposal_file) }}" target="_blank" class="text-blue-600 hover:underline">View Document</a></div>
                                </div>
            
            
                                <div class="flex flex-col w-[80%] md:w-[60%]">
                                    {{--  @include('partials._session_response') --}} 
                                    @if(session()->has('error'))
                                        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-300 text-red-700">
                                            <strong>Error:</strong> {{ session('error') }}
                                        </div>
                                    @endif

                                    @if(session()->has('success'))
                                        <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-300 text-green-700">
                                            <strong>Success:</strong> {{ session('success') }}
                                        </div>
                                    @endif
                                </div>
                                <table class='w-full border border-green-600 rounded-md'>
                                    <tbody>
                                        @foreach ($scoring_guides as  $section => $scoring_guides)
                                            <tr>
                                                <td colspan="3" class='w-full py-4 px-4 bg-green-600 text-white font-semibold text-lg text-left'>Section {{ $section }}</td>
                                            </tr>   
                                            @foreach ($scoring_guides as  $scoring_guide)
                                                <tr class='border-b border-gray-900'>
                                                        <td class='w-[5%] text-center items-center justify-start  text-center border-0 px-4 bg-green-600 text-white'><div class='border-0'>{{ $scoring_guide->sn }}.</div></td>
                                                        <td class='w-[65%] md:w-[75%] py-4 px-4'>
                                                            {!! nl2br($scoring_guide->criterium) !!}
                                                            <div class='py-2 font-semibold text-sm text-end'>Mark Obtainable: {{ $scoring_guide->mark_obtainable }}</div>

                                                        </td>
                                                        <td class='w-full px-3 py-8 border-0  flex flex-col w-full items-center justify-center'>
                                                            <!-- username //-->
                                                            <div class="flex flex-col border ">

                                                                <input type="text" name="scoring_guide_{{ $scoring_guide->id }}" class="w-full border border-1 border-gray-400 bg-gray-50
                                                                                                        w-full p-4 rounded-md 
                                                                                                        focus:outline-none
                                                                                                        focus:border-blue-500 
                                                                                                        focus:ring
                                                                                                        focus:ring-blue-100 text-center"                                                                                        
                                                                                                    
                                                                                                        value="{{ old('scoring_guide_'.$scoring_guide->id) }}"
                                                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                                                        required
                                                                                                        />  
                                                                                                                                                                            

                                                                                                        @error("scoring_guide_{{ $scoring_guide->id }}")
                                                                                                            <span class="text-red-700 text-sm">
                                                                                                                {{$message}}
                                                                                                            </span>
                                                                                                        @enderror
                                                                
                                                            </div><!-- end of surname //-->
                                                        </td>
                                                </tr>
                                            @endforeach
                                            
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- Comment //-->
                                <div class="flex flex-col border-red-900 w-[100%] md:w-[100%] py-3">
                                
                                    
                                    <textarea type="text" name="comment" class="border border-1 border-gray-400 bg-gray-50
                                                                            w-full p-4 rounded-md 
                                                                            focus:outline-none
                                                                            focus:border-blue-500 
                                                                            focus:ring
                                                                            focus:ring-blue-100" placeholder="Comment"
                                                                            
                                                                            rows="5"
                                                                            
                                                                            style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                            
                                                                            ></textarea> 
                                                                                                                                                
            
                                                                            @error('comment')
                                                                                <span class="text-red-700 text-sm">
                                                                                    {{$message}}
                                                                                </span>
                                                                            @enderror
                                    
                                </div><!-- end of Comment //--> 

                                        
            
                                <div class="flex flex-col border-red-900 w-[100%] md:w-[100%] mt-4">
                                    <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                                hover:bg-green-600
                                                rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Submit</button>
                                </div>
                                
                            </form><!-- end of new Call for Proposal form //-->
                        <div>
            
                    

                </section>
                <!-- End of Create Call for Proposals Section //-->
        @else
                  <section class="py-8 mt-2  w-[90%] md:w-[60%] mx-auto"">
                        <div>
                            <div class="flex flex-col mx-auto w-full md:w-[95%] items-center justify-center">
                                
            
                                
            
                                <div class="flex flex-col w-[90%] md:w-[60%] py-2 md:py-4" style="font-family:'Lato'; font-size:18px; font-weight:400;">
                                <h2 class="font-semibold text-xl py-1 text-center" >PROPOSAL HAS BEEN REVIEWED</h2>
                                <div>Thank you for taking the time and effort to review the proposal.</div>
                                    
                                </div>
                            </div>
                        </div>
                  </section>
            
        @endif



    </div>

</x-guest-layout>