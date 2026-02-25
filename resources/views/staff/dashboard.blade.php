<x-staff-layout>

<div class="flex flex-col container mx-4 border border-0 md:mx-auto">
    <section class="border-b border-gray-200 py-2 mt-2">
            <div class="text-2xl font-semibold ">
                Dashboard                
            </div>
            <div>
                @if (Auth::check())
                    Welcome {{ Auth::user()->surname }} {{ Auth::user()->firstname}}
                @endif
            </div>
    </section>

    


    <div class="flex flex-col mt-2 border-0 mx-auto w-[100%]">
        
            @if ($call_for_proposals->count())
                @foreach ($call_for_proposals as $call_for_proposal)
                    
                
                        <div class="mx-auto w-[95%] md:w-[90%] flex flex-col py-8">
                                <div class='text-xl md:text-2xl font-semibold border-b border-gray-300'>{{ $call_for_proposal->first()->title }}</div>
                                <div class='py-4'>{{ $call_for_proposals->first()->description }}</div>
                                <div class="flex flex-col md:flex-row gap-x-20 ">
                                    <div><strong>Opening Date:</strong> {{ Carbon\Carbon::parse($call_for_proposal->first()->open_date)->format('l jS F, Y') }}</div>
                                    <div><strong>Closing Date:</strong> {{ Carbon\Carbon::parse($call_for_proposal->first()->close_date)->format('l jS F, Y') }}</div>
                                </div>
                                <div>
                                   
                                        @php
                                            $advert = optional($call_for_proposal->first())->advert;
                                        @endphp

                                        @if ($advert)
                                            <div class="flex flex-row justify-between items-center mt-4 border-0 ">
                                                <div>
                                                        <a 
                                                            href="{{ asset('storage/'.$advert) }}" 
                                                            target="_blank"
                                                            class="text-blue-600 hover:underline text-md"
                                                        >
                                                            View Advert
                                                        </a>  
                                                </div>
                                                
                                                <div class="flex flex-col justify-center items-center border-0">
                                                        @if (\Carbon\Carbon::now()->between(\Carbon\Carbon::parse($call_for_proposal->open_date), \Carbon\Carbon::parse($call_for_proposal->close_date)))
                                                            <a href="{{ route('staff.call_for_proposals.application', ['uuid' => $call_for_proposal->first()->uuid]) }}" class='font-semibold py-2 px-4 bg-green-500 text-white text-sm md:text-md rounded-md'>Apply for this call for proposal</a>
                                                        @else
                                                            <div class='font-semibold py-2 px-4 bg-red-400 text-white text-sm md:text-md rounded-md'>Application has Closed</div>
                                                                           
                                                        @endif      
                                                        
                                                </div>     
                                            </div>
                                        @else                                   
                                       
                                        @endif

                                </div>
                        </div>

                @endforeach                        
                   
            @endif
                    
        



        

    </div>


    
</div>

</x-staff-layout>