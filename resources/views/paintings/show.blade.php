@extends('layouts.app')

@section('title', $painting->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('paintings.index') }}" class="inline-flex items-center gap-2 text-sm text-amber-900 hover:text-amber-950 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Paintings
            </a>
        </div>

        @if(session('success'))
            <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        <div class="space-y-4 sm:space-y-5">
            {{-- Image box --}}
            <div class="painting-show__box painting-show__box--image">
                <div class="painting-show__preview-frame painting-show__preview-frame--single">
                    @if($painting->photoUrl())
                        <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="painting-show__image painting-show__image--single">
                    @else
                        <div class="painting-show__image-placeholder">
                            <svg class="w-16 h-16 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm">No photo uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Title & price box --}}
            <div class="painting-show__box">
                <div class="flex flex-wrap gap-2 mb-3">
                    <x-badge variant="primary">{{ $painting->production_year }}</x-badge>
                    <x-badge variant="default">{{ $painting->media }}</x-badge>
                    <x-badge variant="primary">{{ $painting->locationTypeLabel() }}</x-badge>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h1 class="painting-show__title">{{ $painting->title }}</h1>
                        <p class="painting-show__painter">{{ $painting->painter_name }}</p>
                    </div>
                    <div class="painting-show__price-box shrink-0">
                        <span class="painting-show__price-amount">{{ number_format((float) $painting->price, 2) }}</span>
                        <span class="painting-show__price-currency">{{ $painting->currency }}</span>
                    </div>
                </div>
            </div>

            {{-- Detail stat boxes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="painting-show__box painting-show__box--stat">
                    <span class="painting-show__stat-label">Location</span>
                    <span class="painting-show__stat-value">
                        @if($painting->location_type === 'hotel' && $painting->hotel)
                            {{ $painting->hotel->name }}
                            <span class="text-gray-400 text-xs block mt-0.5">{{ $painting->hotel->pms_code }}</span>
                        @else
                            {{ $painting->locationLabel() }}
                        @endif
                    </span>
                </div>
                <div class="painting-show__box painting-show__box--stat">
                    <span class="painting-show__stat-label">With Frame</span>
                    <span class="painting-show__stat-value">{{ $painting->dimensionsWithFrameLabel() }}</span>
                </div>
                <div class="painting-show__box painting-show__box--stat">
                    <span class="painting-show__stat-label">Without Frame</span>
                    <span class="painting-show__stat-value">{{ $painting->dimensionsWithoutFrameLabel() }}</span>
                </div>
                <div class="painting-show__box painting-show__box--stat">
                    <span class="painting-show__stat-label">Production Year</span>
                    <span class="painting-show__stat-value">{{ $painting->production_year }}</span>
                </div>
            </div>

            {{-- Certificate box --}}
            <div class="painting-show__box">
                <h2 class="painting-show__box-title">Certificate of Authenticity</h2>
                @if($painting->certificate_type === 'text')
                    <p class="text-gray-900 text-sm whitespace-pre-wrap leading-relaxed">{{ $painting->certificate_text ?: '—' }}</p>
                @elseif($painting->certificateUrl())
                    <a href="{{ $painting->certificateUrl() }}" target="_blank" class="inline-flex items-center gap-2 text-amber-900 hover:text-amber-950 font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View / Download Certificate
                    </a>
                    <form action="{{ route('paintings.update', $painting) }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-gray-100">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="location_type" value="{{ $painting->location_type }}">
                        <input type="hidden" name="hotel_id" value="{{ $painting->hotel_id }}">
                        <input type="hidden" name="location_id" value="{{ $painting->location_id }}">
                        <input type="hidden" name="title" value="{{ $painting->title }}">
                        <input type="hidden" name="painter_name" value="{{ $painting->painter_name }}">
                        <input type="hidden" name="price" value="{{ $painting->price }}">
                        <input type="hidden" name="currency" value="{{ $painting->currency }}">
                        <input type="hidden" name="media" value="{{ $painting->media }}">
                        <input type="hidden" name="production_year" value="{{ $painting->production_year }}">
                        <input type="hidden" name="width_with_frame" value="{{ $painting->width_with_frame }}">
                        <input type="hidden" name="height_with_frame" value="{{ $painting->height_with_frame }}">
                        <input type="hidden" name="width_without_frame" value="{{ $painting->width_without_frame }}">
                        <input type="hidden" name="height_without_frame" value="{{ $painting->height_without_frame }}">
                        <input type="hidden" name="owned_by" value="{{ $painting->owned_by }}">
                        <input type="hidden" name="purchased_by" value="{{ $painting->purchased_by }}">
                        <input type="hidden" name="purchased_from" value="{{ $painting->purchased_from }}">
                        <input type="hidden" name="paid_by" value="{{ $painting->paid_by }}">
                        <input type="hidden" name="certificate_type" value="file">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Replace certificate file</label>
                        <input type="file" name="certificate_file" accept=".pdf,image/jpeg,image/png,image/webp" class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-900 file:font-medium" required>
                        <button type="submit" class="btn btn-secondary mt-3 text-sm">Upload New Certificate</button>
                    </form>
                @else
                    <p class="text-gray-500 text-sm">No certificate on file.</p>
                @endif
            </div>

            {{-- Ownership box --}}
            <div class="painting-show__box">
                <h2 class="painting-show__box-title">Ownership & Purchase</h2>
                <dl class="painting-show__details-list">
                    @foreach([
                        ['Owned By', $painting->owned_by],
                        ['Purchased By', $painting->purchased_by],
                        ['Purchased From', $painting->purchased_from],
                        ['Paid By', $painting->paid_by],
                    ] as [$label, $value])
                        <div class="painting-show__details-row">
                            <dt>{{ $label }}</dt>
                            <dd>{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Notes: each note in its own box --}}
            @forelse($painting->notes as $note)
                <div class="painting-show__box painting-show__box--note">
                    <p class="painting-show__note-body">{{ $note->body }}</p>
                    <div class="painting-show__note-meta">
                        <span class="painting-show__note-author">{{ $note->user->full_name }}</span>
                        <span class="painting-show__note-date">{{ $note->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </div>
            @empty
                <div class="painting-show__box painting-show__box--note painting-show__box--empty">
                    <p class="text-sm text-gray-500">No notes yet.</p>
                </div>
            @endforelse

            {{-- Add note box --}}
            <div class="painting-show__box">
                <h2 class="painting-show__box-title">Add a Note</h2>
                <form action="{{ route('paintings.notes.store', $painting) }}" method="POST">
                    @csrf
                    <textarea name="body" id="body" rows="3" class="form-input" required placeholder="Write a note...">{{ old('body') }}</textarea>
                    @error('body')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    <button type="submit" class="btn btn-primary mt-3 text-sm">Add Note</button>
                </form>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 pb-4">
                <a href="{{ route('paintings.edit', $painting) }}" class="btn btn-primary btn-block-sm">Edit Painting</a>
                <form action="{{ route('paintings.destroy', $painting) }}" method="POST" onsubmit="return confirm('Delete this painting?')" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block-sm w-full">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
