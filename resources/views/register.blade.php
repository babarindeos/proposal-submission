<x-guest-layout>
<div class="flex flex-col w-full borders h-full items-center justify-center border-0">

            
            <div class="flex flex-col w-full  md:w-[30%] items-center justify-start py-8 bg-gray-50 mx-auto border rounded-md mt-10">

                <section class="flex flex-col w-full border border-0">
                    <div class="flex flex-col w-full border border-0" >
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
                    <form  action="{{ route('guest.auth.register.store') }}" method="POST" class="flex flex-col mx-auto w-[90%] items-center justify-center space-y-2">
                            @csrf

                            <div class="flex flex-col w-[80%] md:w-[80%] py-4 mt-4 font-serif" >
                                <h2 class="font-semibold text-xl py-1" >Register</h2>
                                
                                
                            </div>

                            <!-- username //-->
                            <div class="w-[80%]">

                                <input type="text" name="surname" class="border border-1 border-gray-400 bg-gray-50
                                                                        w-full p-4 rounded-md 
                                                                        focus:outline-none
                                                                        focus:border-blue-500 
                                                                        focus:ring
                                                                        focus:ring-blue-100" placeholder="Surname"
                                                                        
                                                                        value="{{ old('surname') }}"
                                                                        
                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                        required
                                                                        />  
                                                                                                                                            

                                                                        @error('surname')
                                                                            <span class="text-red-700 text-sm">
                                                                                {{$message}}
                                                                            </span>
                                                                        @enderror
                                
                            </div><!-- end of surname //-->


                            <!-- firstname //-->
                            <div class="w-[80%]">

                                <input type="text" name="firstname" class="border border-1 border-gray-400 bg-gray-50
                                                                        w-full p-4 rounded-md 
                                                                        focus:outline-none
                                                                        focus:border-blue-500 
                                                                        focus:ring
                                                                        focus:ring-blue-100" placeholder="Firstname"
                                                                        
                                                                        value="{{ old('firstname') }}"
                                                                        
                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                        required
                                                                        />  
                                                                                                                                            

                                                                        @error('firstname')
                                                                            <span class="text-red-700 text-sm">
                                                                                {{$message}}
                                                                            </span>
                                                                        @enderror
                                
                            </div><!-- end of firstname //-->


                            <!-- middlename //-->
                            <div class="w-[80%]">

                                <input type="text" name="middlename" class="border border-1 border-gray-400 bg-gray-50
                                                                        w-full p-4 rounded-md 
                                                                        focus:outline-none
                                                                        focus:border-blue-500 
                                                                        focus:ring
                                                                        focus:ring-blue-100" placeholder="Middlename"
                                                                        
                                                                        value="{{ old('middlename') }}"
                                                                        
                                                                        style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                                                        required
                                                                        />  
                                                                                                                                            

                                                                        @error('middlename')
                                                                            <span class="text-red-700 text-sm">
                                                                                {{$message}}
                                                                            </span>
                                                                        @enderror
                                
                            </div><!-- end of middlename //-->

                            <!-- password //-->
                            <div class="w-[80%]">

                                <input type="email" name="email" class="border border-1 border-gray-400 bg-gray-50
                                    w-full p-4 rounded-md 
                                    focus:outline-none
                                    focus:border-blue-500 
                                    focus:ring
                                    focus:ring-blue-100" placeholder="Email"
                                    
                                    value="{{ old('email') }}"
                                    
                                    style="font-family:'Lato';font-size:16px;font-weight:500;"                                                                     
                                    required
                                    />  
                                                                                                        

                                    @error('email')
                                        <span class="text-red-700 text-sm">
                                            {{$message}}
                                        </span>
                                    @enderror

                            </div><!-- end of password //-->
                            

                            <!-- submit //-->
                            <!-- submit button //-->
                            <div class="flex flex-col border-red-900 w-[80%] md:w-[80%] py-1 md:py-2">
                                <button type="submit" class="border border-1 bg-gray-400 py-4 text-white 
                                               hover:bg-gray-500
                                               rounded-md text-lg" style="font-family:'Lato';font-weight:500;">Submit</button>
                            </div>

                            <!-- end of submit //-->
                            <div class='w-[80%] py-4'>Already Registered? <span class='underline'>Login</span>   </div>
                        </form>
                        
                    </div>

                    
                </section>


                
                    
            </div>
            
    </div>


</div>
</x-guest-layout>