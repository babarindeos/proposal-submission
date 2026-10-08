<x-guest-layout>
<div class="flex flex-col w-full py-8 px-4 md:px-10">

    <section class="flex flex-col border-b border-gray-200 pb-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-semibold font-serif text-gray-800">Calls for Proposals</h1>
        <p class="text-gray-600 mt-1">All research calls published by DRIP, past and present.</p>
    </section>

    <section class="flex flex-col gap-6">
        @forelse ($call_for_proposals as $call_for_proposal)
            @php
                $status = $call_for_proposal->computed_status;
                $badge = match($status) {
                    'Open' => 'bg-green-100 text-green-800',
                    'Upcoming' => 'bg-blue-100 text-blue-800',
                    default => 'bg-gray-200 text-gray-700',
                };
            @endphp
            <div class="w-full flex flex-col py-6 border rounded-md px-4 md:px-6 shadow-sm border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-100 pb-3">
                    <div class="text-xl md:text-2xl font-semibold text-green-800">{{ $call_for_proposal->title }}</div>
                    <span class="mt-2 md:mt-0 self-start md:self-auto text-xs font-semibold px-3 py-1 rounded-full {{ $badge }}">{{ $status }}</span>
                </div>

                <div class="py-4 text-gray-700">{{ $call_for_proposal->description }}</div>

                <div class="flex flex-col md:flex-row gap-x-20 text-sm text-gray-700">
                    <div><strong>Opening Date:</strong> {{ $call_for_proposal->open_date->format('l jS F, Y') }}</div>
                    <div><strong>Closing Date:</strong> {{ $call_for_proposal->close_date->format('l jS F, Y') }}</div>
                </div>

                <div class="flex flex-row justify-between items-center mt-4">
                    <div>
                        @if ($call_for_proposal->advert)
                            <a href="{{ asset('storage/'.$call_for_proposal->advert) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Advert</a>
                        @endif
                    </div>

                    <div>
                        @if ($status === 'Open')
                            <a href="{{ route('welcome') }}#signin" class="font-semibold py-2 px-4 bg-green-500 text-white text-sm rounded-md hover:bg-green-600">Sign in to Apply</a>
                        @else
                            <span class="font-semibold py-2 px-4 bg-gray-300 text-gray-700 text-sm rounded-md">{{ $status === 'Upcoming' ? 'Not Yet Open' : 'Closed' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-600">There are no calls for proposals to show yet.</div>
        @endforelse

        <div class="mt-2">{{ $call_for_proposals->links() }}</div>
    </section>
</div>
</x-guest-layout>
