@if($paintings->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 sm:p-14 text-center">
        <div class="text-5xl mb-4 opacity-80">🖼️</div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">No paintings found</h2>
        <p class="text-gray-500 text-sm mb-6">Try adjusting your filters or add a new painting to the catalog.</p>
        <a href="{{ route('paintings.create') }}" class="btn btn-primary">Add Painting</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden mb-4">
        @foreach($paintings as $painting)
            @include('paintings._index-card', ['painting' => $painting])
        @endforeach
    </div>

    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="paintings-table">
                <thead>
                    <tr>
                        <th class="paintings-table__th paintings-table__th--photo">Artwork</th>
                        <th class="paintings-table__th">Details</th>
                        <th class="paintings-table__th paintings-table__th--location">Location</th>
                        <th class="paintings-table__th paintings-table__th--price">Price</th>
                        <th class="paintings-table__th paintings-table__th--actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paintings as $painting)
                        <tr class="paintings-table__row">
                            <td class="paintings-table__td paintings-table__td--photo">
                                @if($painting->photoUrl())
                                    <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="paintings-table__photo">
                                @else
                                    <div class="paintings-table__photo-placeholder">N/A</div>
                                @endif
                            </td>
                            <td class="paintings-table__td">
                                <div class="paintings-table__details">
                                    <a href="{{ route('paintings.show', $painting) }}" class="paintings-table__title">{{ $painting->title }}</a>
                                    <p class="paintings-table__painter">{{ $painting->painter_name }}</p>
                                    <div class="paintings-table__chips">
                                        <span class="paintings-table__chip">{{ $painting->production_year }}</span>
                                        <span class="paintings-table__chip">{{ $painting->media }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="paintings-table__td paintings-table__td--location">
                                <span class="paintings-table__location-type">{{ $painting->locationTypeLabel() }}</span>
                                <p class="paintings-table__location-name" title="{{ $painting->locationLabel() }}">{{ $painting->locationLabel() }}</p>
                            </td>
                            <td class="paintings-table__td paintings-table__td--price">
                                <div class="paintings-table__price">
                                    <span class="paintings-table__price-amount">{{ number_format((float) $painting->price, 2) }}</span>
                                    <span class="paintings-table__price-currency">{{ $painting->currency }}</span>
                                </div>
                            </td>
                            <td class="paintings-table__td paintings-table__td--actions">
                                <div class="paintings-table__actions">
                                    <a href="{{ route('paintings.show', $painting) }}" class="paintings-table__action paintings-table__action--primary">View</a>
                                    <a href="{{ route('paintings.edit', $painting) }}" class="paintings-table__action">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($paintings->hasPages())
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 pagination-nav" id="paintings-pagination">
            {{ $paintings->links() }}
        </div>
    @endif
@endif

<div id="paintings-results-meta" data-total="{{ $paintings->total() }}" hidden></div>
