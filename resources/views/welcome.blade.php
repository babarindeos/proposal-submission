<x-guest-layout>
<div class="flex flex-col w-full borders h-full">

    <div class="flex flex-col md:flex-row  ">
            <!-- left  panel //-->
            <div class="flex flex-col w-full w-[90%] md:w-[70%] ">
                    @if ($call_for_proposals->count())

                        <div class="mx-auto w-[90%] md:w-[80%] flex flex-col py-8">
                                <div class='text-2xl font-semibold border-b border-gray-300'>{{ $call_for_proposals->first()->title }}</div>
                                <div class='py-4'>{{ $call_for_proposals->first()->description }}</div>
                                <div class="flex flex-row gap-10 ">
                                    <div><strong>Opening Date:</strong> {{ Carbon\Carbon::parse($call_for_proposals->first()->open_date)->format('l jS F, Y') }}</div>
                                    <div><strong>Closing Date:</strong> {{ Carbon\Carbon::parse($call_for_proposals->first()->close_date)->format('l jS F, Y') }}</div>
                                </div>
                                <div>
                                   
                                        @php
                                            $advert = optional($call_for_proposals->first())->advert;
                                        @endphp

                                        @if ($advert)
                                            @php
                                                $ext = strtolower(pathinfo($advert, PATHINFO_EXTENSION));
                                                $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                            @endphp

                                            @if (in_array($ext, $imageExt))
                                                <img 
                                                    src="{{ asset('storage/'.$advert) }}" 
                                                    alt="Call for Proposal Advert"
                                                    class="mt-4 max-w-full h-auto rounded-md shadow-md"
                                                >
                                            @else
                                                <a 
                                                    href="{{ asset('storage/'.$advert) }}" 
                                                    target="_blank"
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    View Advert
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-gray-600 italic">
                                                No advert uploaded for this call for proposal.
                                            </span>
                                        @endif

                                </div>
                        </div>
                        
                    @else
                        <img src="{{ asset('images/goviflow_low.jpg') }}" />
                    @endif
                    
            </div>
            <!-- end of left panel //-->



            <!-- Right  panel //-->
            <div class="flex flex-col w-full  md:w-[30%] items-center justify-start py-8 bg-gray-50">

                <section class="flex flex-col w-full border border-0">
                    <div class="flex flex-col w-full border border-0" >
                    <form  action="{{ route('staff.auth.login') }}" method="POST" class="flex flex-col mx-auto w-[90%] items-center justify-center space-y-2">
                            @csrf

                            <div class="flex flex-col w-[80%] md:w-[80%] py-4 mt-4 font-serif" >
                                <h2 class="font-semibold text-xl py-1" >Sign In</h2>
                                
                                
                            </div>

                            <!-- username //-->
                            <div class="w-[80%]">

                                <input type="text" name="email" class="border border-1 border-gray-400 bg-gray-50
                                                                        w-full p-4 rounded-md 
                                                                        focus:outline-none
                                                                        focus:border-blue-500 
                                                                        focus:ring
                                                                        focus:ring-blue-100" placeholder="Username"
                                                                        
                                                                        value="{{ old('email') }}"
                                                                        
                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                        required
                                                                        />  
                                                                                                                                            

                                                                        @error('email')
                                                                            <span class="text-red-700 text-sm">
                                                                                {{$message}}
                                                                            </span>
                                                                        @enderror
                                
                            </div><!-- end of username //-->

                            <!-- password //-->
                            <div class="w-[80%]">

                                <input type="password" name="password" class="border border-1 border-gray-400 bg-gray-50
                                    w-full p-4 rounded-md 
                                    focus:outline-none
                                    focus:border-blue-500 
                                    focus:ring
                                    focus:ring-blue-100" placeholder="Password"
                                    
                                    value="{{ old('password') }}"
                                    
                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                    required
                                    />  
                                                                                                        

                                    @error('password')
                                        <span class="text-red-700 text-sm">
                                            {{$message}}
                                        </span>
                                    @enderror

                            </div><!-- end of password //-->
                            <div class='text-sm underline text-right border-0 w-4/5'>
                                Forgot Password
                            </div>

                            <!-- submit //-->
                            <!-- submit button //-->
                            <div class="flex flex-col border-red-900 w-[80%] md:w-[80%] py-1 md:py-2">
                                <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                               hover:bg-gray-500
                                               rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Login</button>
                            </div>

                            <!-- end of submit //-->
                            <div class='w-[80%] py-4'>Don't have an account? <a href="{{ route('guest.auth.register') }}" class='underline'>Register</a>   </div>
                        </form>
                        
                    </div>

                    
                </section>


                
                    
            </div>
            <!-- end of right panel //-->
    </div>


</div>
</x-guest-layout>