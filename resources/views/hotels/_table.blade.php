<div class="table-responsive">
    <table class="data-table">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left font-semibold text-gray-700">Hotel Name</th>
                <th class="text-left font-semibold text-gray-700 hidden sm:table-cell">PMS Code</th>
                <th class="text-left font-semibold text-gray-700">Status</th>
                <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Paintings</th>
                <th class="text-left font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200" id="hotels-table-body">
            @forelse($hotels as $hotel)
                <tr class="hover:bg-gray-50">
                    <td class="font-medium text-gray-900">
                        <div>{{ $hotel->name }}</div>
                        <div class="text-xs text-gray-500 sm:hidden mt-0.5">{{ $hotel->pms_code }}</div>
                    </td>
                    <td class="text-gray-700 hidden sm:table-cell">{{ $hotel->pms_code }}</td>
                    <td>
                        <x-badge :variant="$hotel->status === 'active' ? 'active' : 'inactive'">
                            {{ ucfirst($hotel->status) }}
                        </x-badge>
                    </td>
                    <td class="text-gray-700 hidden md:table-cell">{{ $hotel->paintings_count }}</td>
                    <td>
                        <a href="{{ route('hotels.show', $hotel) }}" class="text-amber-900 hover:text-amber-950 font-medium text-sm sm:text-base">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-8">No hotels found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($hotels->hasPages())
    <div class="border-t border-gray-200 pagination-nav" id="hotels-pagination">
        {{ $hotels->links() }}
    </div>
@else
    <div class="hidden" id="hotels-pagination"></div>
@endif
