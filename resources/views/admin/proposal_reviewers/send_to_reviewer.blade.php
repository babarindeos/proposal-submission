<x-admin-layout>

    <div class="flex flex-col border-0 border-red-900 w-full">
        <section class="flex flex-row justify-between border-b border-gray-200 py-2 px-8 md:px-10 mt-6">
                <div>
                    <div class="text-2xl font-semibold ">
                        Proposal Application 
                    </div>
                    <div class='text-lg'>{{ $proposal_application->call_for_proposal->title }}</div>
                </div>

                <div>                          


                            <a href="{{ route('admin.call_for_proposals.index') }}" class="border border-green-600 text-green-600 py-2 px-6 
                                            rounded-lg text-xs md:text-sm hover:bg-green-500 hover:text-white hover:border-green-500">Call for Proposals</a>
                </div>
                
        </section>
       
        
       
    
        <section class="py-8 mt-2">
                <div>
                    <form  action="{{ route('admin.call_for_proposals.proposal_application.send_to_reviewer.store',['proposal_application' => $proposal_application->id]) }} " method="POST" enctype="multipart/form-data" class="flex flex-col mx-auto w-full md:w-[95%] items-center justify-center">
                        @csrf
    
                        
    
                        <div class="flex flex-col w-[80%] md:w-[60%] py-2 md:py-4" style="font-family:'Lato'; font-size:18px; font-weight:400;">
                            <h2 class="font-semibold text-xl py-1" >Send Proposal to Reviewer</h2>
                            
                        </div>
    
    
                        <div class="flex flex-col w-[80%] md:w-[60%] mx-auto border-0">
                            @include('partials._session_response')
                        </div>
                        

                        <!-- Title //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-3">
                        
                            
                            <input disabled name="title" class="border border-1 border-gray-400 bg-gray-50
                                                                    w-full p-4 rounded-md 
                                                                    focus:outline-none
                                                                    focus:border-blue-500 
                                                                    focus:ring
                                                                    focus:ring-blue-100" placeholder="Title"

                                                                    value="{{ $proposal_application->proposal_title }}"
                                                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                    
                                                                    />
                                                                    <span><div class='text-sm  py-1'><b>Edited:</b> <a target='_blank' class='underline text-blue-700' href="{{ asset('storage/'.$proposal_application->proposal_file) }}">{{ $proposal_application->proposal_file }}</a></div></span>                                                                   
                                                                    <span><div class='text-sm  py-1'><b>Title Page:</b> <a target='_blank' class='underline text-blue-700' href="{{ asset('storage/'.$proposal_application->proposal_title_file) }}">{{ $proposal_application->proposal_title_file }}</a></div></span>
                                                                    
    
                                                                    @error('title')
                                                                        <span class="text-red-700 text-sm">
                                                                            {{$message}}
                                                                        </span>
                                                                    @enderror
                            
                        </div><!-- end of Title //--> 


                         
                        <!-- Reviewer //-->
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] py-2">
                                        
                                    <input type='hidden' name='reviewer_id' id='reviewer_id' />
                                
                                    <input name="reviewer" id="reviewer" class="border border-1 border-gray-400 bg-gray-50
                                                                            w-full p-4 rounded-md 
                                                                            focus:outline-none
                                                                            focus:border-blue-500 
                                                                            focus:ring
                                                                            focus:ring-blue-100"                                                                                                                                                                                                                                                                                                                                                
                                                                            
                                                                            
                                                                            required
                                                                            />
                                                                            
                                                                            <div id='suggestion-box' class='border py-2 px-2 w-[47.7%] bg-green-100 text-black' 
                                                                                 style='position:absolute; top:489px; z-index:1000; display:none; padding-left:2px;'></div>

                                                                            @error('reviewer')
                                                                                <span class="text-red-700 text-sm">
                                                                                    {{$message}}
                                                                                </span>
                                                                            @enderror

                                                                            @error('reviewer_id')
                                                                                <span class="text-red-700 text-sm">
                                                                                    {{$message}}
                                                                                </span>
                                                                            @enderror
                                    
                        </div>                                
                        <!-- end of Reviewer //-->  
    
                        
                        
    
                       
                        
                       
                                  
    
                        <div class="flex flex-col border-red-900 w-[80%] md:w-[60%] mt-4">
                            <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                           hover:bg-gray-500
                                           rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Submit</button>
                        </div>
                        
                    </form><!-- end of new Call for Proposal form //-->
                <div>
    
            

        </section>
        <!-- End of Create Call for Proposals Section //-->


         <section class="py-2 mt-1 border-0 w-[90%] md:w-[80%] mx-auto mb-5">
                <div>
                    <div class="flex flex-col mx-auto w-full md:w-[95%] items-start justify-start">
                        <table class='w-full'>
                            <tr class='border' >
                                <td class='text-gray-800 p-4 font-semibold border' colspan='5'>
                                     Reviewers ({{ $proposal_application->reviews->count() }})
                                </td>
                            </tr>
                            <tr class='border bg-gray-100' >
                                <td class='text-gray-800 p-4 font-semibold border' >SN</td>
                                <td class='text-gray-800 p-4 font-semibold border' >Names</td>
                                <td class='text-gray-800 p-4 font-semibold border' >Status</td>
                                <td class='text-gray-800 p-4 font-semibold border' >Review Link</td>
                                <td class='text-gray-800 p-4 font-semibold border' >Action</td>
                            </tr>
                            <tbody>
                                 @php
                                    $counter = 0;
                                 @endphp

                                 @foreach($proposal_application->reviews as $review)
                                        @php
                                            $link = $review->review_link ?: $review->buildReviewLink();
                                        @endphp
                                        <tr class='border align-top'>
                                            <td class='border text-center py-4' width='6%'> {{ ++$counter }}.</td>
                                            <td class='py-4 px-4 border' width='20%'>
                                                <div>{{ $review->reviewer->name }}</div>
                                                <div class='text-xs text-gray-500'>{{ $review->reviewer->email }}</div>
                                            </td>
                                            <td class='border p-4 text-sm' width='16%'>
                                                @if ($review->is_reviewed)
                                                        <div class='text-green-700 font-semibold'>Review has been done</div>
                                                @else
                                                        <div class='text-amber-600 font-semibold'>Awaiting Review</div>
                                                @endif
                                                <div class='text-xs mt-1'>
                                                    @if ($review->emailed_at)
                                                        <span class='text-green-700'>Emailed {{ $review->emailed_at->format('M j, Y g:i A') }}</span>
                                                    @elseif ($review->email_error)
                                                        <span class='text-red-600' title="{{ $review->email_error }}">Email failed - send the link manually</span>
                                                    @else
                                                        <span class='text-gray-500'>Not emailed yet</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class='border p-4' width='34%'>
                                                <input type='text' readonly value="{{ $link }}" id="link-{{ $review->id }}" onclick="this.select()"
                                                       class='w-full border border-gray-300 bg-gray-50 rounded-md p-2 text-xs' />
                                                <button type='button' onclick="copyLink('link-{{ $review->id }}', this)"
                                                        class='mt-2 text-xs border rounded-md py-1 px-3 border-blue-500 text-blue-700 hover:bg-blue-50'>Copy link</button>
                                            </td>
                                            <td class='border p-4' width='24%'>
                                                @if ($review->is_reviewed)
                                                    <span class='text-xs text-gray-500'>Locked - review submitted</span>
                                                @else
                                                    <div class='flex flex-col gap-y-2'>
                                                        <form action="{{ route('admin.call_for_proposals.proposal_application.proposal_reviewer.resend', ['proposal_reviewer' => $review->id]) }}" method='post'>
                                                            @csrf
                                                            <button type='submit' class='text-xs border rounded-md py-2 px-4 border-blue-500 text-blue-700 hover:bg-blue-50'>Resend email</button>
                                                        </form>
                                                        <form action="{{ route('admin.call_for_proposals.proposal_application.proposal_reviewer.destroy', ['proposal_reviewer' => $review->id]) }}" method='post' onsubmit="return confirm('Remove this reviewer from the proposal?');">
                                                            @csrf
                                                            @method('delete')
                                                            <button type='submit' class='text-xs border rounded-md py-2 px-4 border-red-500 '>Remove</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
         </section>
    

    </div>

</x-admin-layout>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function copyLink(inputId, btn) {
        var input = document.getElementById(inputId);
        input.select();
        input.setSelectionRange(0, 99999);

        var done = function () {
            var original = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(function () { btn.textContent = original; }, 1500);
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(input.value).then(done);
        } else {
            document.execCommand('copy');
            done();
        }
    }
</script>
<script>
    $(document).ready(function(){
            $("#reviewer").bind("keyup", function(){
                var searchTerm = $(this).val().trim()

                var search_term_length = searchTerm.length;

                //console.log(search_term_length);

                if (search_term_length >=3)
                {
                        //alert(searchTerm);
                        $.ajax({
                            url: "{{ route('admin.reviewers.fetch_reviewer') }}",
                            method: 'GET',
                            data: {search_term: searchTerm}, 
                            success: function(response){
                                console.log(response)

                                if (!response || $.trim(response) === "" || response.length === 0)
                                {
                                    $("#suggestion-box").html("<div class='py-3 border border-gray-500 cursor-pointer px-2'>No reviewers found</div>");
                                }
                                else
                                {
                                    $("#suggestion-box").html(response);
                                    $("#suggestion-box").show();
                                }
                            },
                            error: function(){

                            }
                        });
                }
                else
                {
                    $("#suggestion-box").html();
                    $("#suggestion-box").hide();
                }

                
            })
    });


    $("#suggestion-box").on("click", ".cursor-pointer", function(){
        var reviewerId = $(this).attr("id");
        var reviewerText = $(this).text();

        $("#reviewer").val(reviewerText);
        $("#reviewer_id").val(reviewerId);


        $("#suggestion-box").hide();
    });

</script>


