<x-staff-layout>

    <div class="flex flex-col border-0 border-red-900 w-full">
        <section class="flex flex-row justify-between border-b border-gray-200 py-2 px-8 md:px-10 mt-6">
                <div class="text-2xl font-semibold ">
                    Call for Proposals
                </div>
        </section>

        <section class="py-8 px-8 md:px-10">
            @include('partials._session_response')

            <div class="flex flex-col gap-4">
                @forelse ($call_for_proposals as $call_for_proposal)
                    @php
                        $status = $call_for_proposal->computed_status;
                        $badge = match($status) {
                            'Open' => 'bg-green-100 text-green-800',
                            'Upcoming' => 'bg-blue-100 text-blue-800',
                            default => 'bg-gray-200 text-gray-700',
                        };
                        $already_applied = in_array($call_for_proposal->id, $applied_call_ids);
                    @endphp
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between border rounded-md px-4 md:px-6 py-4 shadow-sm border-gray-200">
                        <div>
                            <div class="flex items-center gap-x-3">
                                <span class="text-lg font-semibold text-gray-800">{{ $call_for_proposal->title }}</span>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge }}">{{ $status }}</span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                {{ $call_for_proposal->open_date->format('M jS, Y') }} — {{ $call_for_proposal->close_date->format('M jS, Y') }}
                            </div>
                        </div>

                        <div class="mt-3 md:mt-0">
                            @if ($already_applied)
                                <a href="{{ route('staff.call_for_proposals.application', ['uuid' => $call_for_proposal->uuid]) }}" class="font-semibold py-2 px-4 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">View My Application</a>
                            @elseif ($status === 'Open')
                                <a href="{{ route('staff.call_for_proposals.application', ['uuid' => $call_for_proposal->uuid]) }}" class="font-semibold py-2 px-4 bg-green-500 text-white text-sm rounded-md hover:bg-green-600">Apply Now</a>
                            @else
                                <span class="font-semibold py-2 px-4 bg-gray-200 text-gray-600 text-sm rounded-md">{{ $status === 'Upcoming' ? 'Not Yet Open' : 'Closed' }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-gray-600">There are no calls for proposals to show right now.</div>
                @endforelse
            </div>
        </section>
    </div>

</x-staff-layout>
