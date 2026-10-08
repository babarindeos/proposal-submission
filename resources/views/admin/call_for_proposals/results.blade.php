<x-admin-layout>
    <div class="container mx-auto">
        <!-- page header //-->
        <section class="flex flex-col w-[95%] md:w-[95%] py-8 px-4 border-red-900 mx-auto">

            <div class="flex border-b border-gray-300 py-2 justify-between">
                    <div>
                        <div class="text-lg font-semibold font-serif text-gray-800">Results</div>
                        <div class="text-xl font-semibold font-serif text-gray-800">{{ $call_for_proposal->title }}</div>
                    </div>
                    <div class="flex gap-x-2">
                            <a href="{{ route('admin.call_for_proposals.submissions',['call_for_proposal' => $call_for_proposal->id]) }}" class="bg-gray-500 text-white py-2 px-4
                                            rounded-lg text-sm hover:bg-gray-400">Back to Submissions</a>
                            <a href="{{ route('admin.call_for_proposals.index') }}" class="bg-green-600 text-white py-2 px-4
                                            rounded-lg text-sm hover:bg-green-500">Call for Proposals</a>
                    </div>
            </div>
        </section>
        <!-- end of page header //-->

        <section class="flex flex-col w-[95%] md:w-[95%] mx-auto px-4">

            @include('partials._session_response')

            <div class="text-sm text-gray-600 mb-3">Ranked by average score across reviewers who have completed a review. Maximum obtainable score per reviewer: <strong>{{ $max_obtainable_score }}</strong>.</div>

            <table class="table-auto border-collapse border border-1 border-gray-200 w-full">
                <tr class="bg-gray-200">
                    <td width="6%" class="text-center font-semibold py-4">Rank</td>
                    <td width="32%" class="font-semibold py-2">Title</td>
                    <td width="18%" class="font-semibold py-2">Principal Investigator (PI)</td>
                    <td width="12%" class="font-semibold py-2 text-center">Reviewers</td>
                    <td width="14%" class="font-semibold py-2 text-center">Average Score</td>
                    <td width="10%" class="font-semibold py-2 text-center">Decision</td>
                    <td width="8%" class="font-semibold py-2 text-center">Action</td>
                </tr>
                <tbody>
                    @forelse ($proposal_applications as $index => $application)
                        <tr class="border border-1 border-gray-200 odd:bg-gray-50 even:bg-white">
                            <td class="text-center py-8 w-16">{{ $index + 1 }}</td>
                            <td class="py-8">
                                <a href="{{ route('admin.call_for_proposals.proposal_application',['call_for_proposal' => $call_for_proposal->id, 'proposal_application' => $application->id ]) }}" class="text-blue-600 hover:underline">{{ $application->proposal_title }}</a>
                            </td>
                            <td class="py-8">{{ $application->principal_investigator }}</td>
                            <td class="py-8 text-center">
                                <span class="@if($application->review_complete) text-green-700 @else text-amber-600 @endif font-semibold">
                                    {{ $application->reviewers_completed_count }} / {{ $application->reviewers_assigned_count }}
                                </span>
                                <div class="text-xs text-gray-500">completed</div>
                            </td>
                            <td class="py-8 text-center font-semibold">
                                @if (is_null($application->average_score))
                                    <span class="text-gray-400">No reviews yet</span>
                                @else
                                    {{ $application->average_score }} / {{ $max_obtainable_score }}
                                @endif
                            </td>
                            <td class="py-8 text-center">
                                @if ($application->status == 'pending')
                                    <span class="text-amber-600 font-semibold">Pending</span>
                                @elseif ($application->status == 'acknowledged')
                                    <span class="text-blue-600 font-semibold">Acknowledged</span>
                                @elseif ($application->status == 'accepted')
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @elseif ($application->status == 'rejected')
                                    <span class="text-red-600 font-semibold">Rejected</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="text-center py-2">
                                <a href="{{ route('admin.call_for_proposals.proposal_application',['call_for_proposal' => $call_for_proposal->id, 'proposal_application' => $application->id ]) }}" class="hover:bg-blue-600 border bg-blue-500 text-white py-2 px-2 text-xs rounded-md">Decide</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500">No applications have been submitted for this call yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </section>
    </div>
</x-admin-layout>
