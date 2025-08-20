<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">
           Purchase History
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-[#27a2a2] mb-2">Purchase History for {{ $member->member_name }}</h2>
                <p class="text-gray-600">IC Number: {{ $member->member_nric }}</p>
            </div>

            @if($receipts->isEmpty())
                <p class="text-gray-500">No purchase history found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#27a2a2]/10">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Receipt Number</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Purchase Date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                            @foreach($receipts as $receipt)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $receipt->receipt_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $receipt->purchase_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $receipt->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('marketing.membership.list') }}" class="inline-flex items-center px-4 py-2 bg-[#27a2a2] text-white rounded-md hover:bg-[#27a2a2]/80 transition-colors">
                    Back to Member List
                </a>
            </div>
        </div>
    </div>
</x-marketing-layout>
