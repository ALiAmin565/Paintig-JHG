@props(['painting'])

<article class="painting-card group">
    <div class="painting-card__media">
        @if($painting->photoUrl())
            <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="painting-card__photo">
        @else
            <div class="painting-card__photo-placeholder">
                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif
        <span class="painting-card__year">{{ $painting->production_year }}</span>
    </div>

    <div class="painting-card__body">
        <div class="painting-card__header">
            <h3 class="painting-card__title">
                <a href="{{ route('paintings.show', $painting) }}" class="hover:text-amber-900 transition-colors">
                    {{ $painting->title }}
                </a>
            </h3>
            <div class="painting-card__price">
                <span class="painting-card__price-amount">{{ number_format((float) $painting->price, 2) }}</span>
                <span class="painting-card__price-currency">{{ $painting->currency }}</span>
            </div>
        </div>

        <p class="painting-card__painter">{{ $painting->painter_name }}</p>

        <div class="painting-card__meta">
            <span class="painting-card__chip">{{ $painting->media }}</span>
            <span class="painting-card__chip painting-card__chip--location">{{ $painting->locationTypeLabel() }}</span>
        </div>

        <p class="painting-card__location" title="{{ $painting->locationLabel() }}">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ $painting->locationLabel() }}
        </p>

        <div class="painting-card__actions">
            <a href="{{ route('paintings.show', $painting) }}" class="painting-card__action painting-card__action--primary">View</a>
            <a href="{{ route('paintings.edit', $painting) }}" class="painting-card__action">Edit</a>
        </div>
    </div>
</article>
