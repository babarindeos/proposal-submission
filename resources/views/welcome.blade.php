<x-guest-layout>
<div class="flex flex-col w-full borders h-full">

    <div class="flex flex-col md:flex-row  ">
            <!-- left  panel //-->
            <div class="order-2 md:order-1 flex flex-col w-full w-[90%] md:w-[70%] gap-6 mt-4 py-5">
                @if ($call_for_proposals->count())
                            @foreach ($call_for_proposals as $call_for_proposal)
                                
                            
                                    <div class="mx-auto w-[95%] md:w-[90%] flex flex-col py-6 border rounded-md px-4 shadow-md border-green-700">
                                            <div class='text-xl md:text-2xl font-semibold border-b border-gray-300 text-green-800'>{{ $call_for_proposal->title }}</div>
                                            <div class='py-4'>{{ $call_for_proposal->description }}</div>
                                            <div class="flex flex-col md:flex-row gap-x-20 ">
                                                <div><strong>Opening Date:</strong> {{ Carbon\Carbon::parse($call_for_proposal->open_date)->format('l jS F, Y') }}</div>
                                                <div><strong>Closing Date:</strong> {{ Carbon\Carbon::parse($call_for_proposal->close_date)->format('l jS F, Y') }}</div>
                                            </div>
                                            <div>
                                            
                                                    @php
                                                        $advert = $call_for_proposal->advert;
                                                    @endphp

                                                 
                                                        <div class="flex flex-row justify-between items-center mt-4 border-0 ">
                                                            
                                                            <div>
                                                                @if ($advert)
                                                                    <a 
                                                                        href="{{ asset('storage/'.$advert) }}" 
                                                                        target="_blank"
                                                                        class="text-blue-600 hover:underline text-md"
                                                                    >
                                                                        View Advert
                                                                    </a>  
                                                                 @endif
                                                            </div>
                                                           
                                                            
                                                            <div class="flex flex-col justify-center items-center border-0">
                                                                    @if (\Carbon\Carbon::now()->between(\Carbon\Carbon::parse($call_for_proposal->open_date), \Carbon\Carbon::parse($call_for_proposal->close_date)))
                                                                        <a href="#" class='font-semibold py-2 px-4 bg-green-500 text-white text-sm md:text-md rounded-md'>Login and Apply for this call</a>
                                                                    @else
                                                                        <div class='font-semibold py-2 px-4 bg-red-400 text-white text-sm md:text-md rounded-md'>Application has Closed</div>
                                                                                    
                                                                    @endif      
                                                                    
                                                            </div>     
                                                        </div>
                                                    

                                            </div>
                                    </div>

                            @endforeach   
                            
                            <div class='px-3 md:px-14'>{{  $call_for_proposals->links() }}</div> 
                   
                @endif
            
                 
                    
            </div>
            <!-- end of left panel //-->



            <!-- Right  panel //-->
            <div class="order-1 md:order-2 flex flex-col w-full md:w-[30%] items-center justify-start py-8 bg-gray-50">

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