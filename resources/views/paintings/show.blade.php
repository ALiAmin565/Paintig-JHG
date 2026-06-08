@extends('layouts.app')

@section('title', $painting->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('paintings.index') }}" class="inline-flex items-center gap-2 text-sm text-amber-900 hover:text-amber-950 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Paintings
        </a>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
        {{-- Left: painting details --}}
        <div class="lg:col-span-5 xl:col-span-5 order-2 lg:order-1">
            <div class="sticky top-24 space-y-6">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <x-badge variant="primary">{{ $painting->production_year }}</x-badge>
                        <x-badge variant="default">{{ $painting->media }}</x-badge>
                    </div>
                    <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold text-gray-900 -tracking-wide break-words leading-tight">
                        {{ $painting->title }}
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-gray-600 flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-900 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $painting->hotel->name }} <span class="text-gray-400">({{ $painting->hotel->pms_code }})</span></span>
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 bg-gradient-to-r from-amber-900 to-amber-950">
                        <h2 class="text-white font-semibold text-sm uppercase tracking-wider">Artwork Details</h2>
                    </div>
                    <dl class="divide-y divide-gray-100">
                        <div class="px-5 py-4 flex justify-between gap-4">
                            <dt class="text-gray-500 text-sm font-medium">Dimensions With Frame</dt>
                            <dd class="text-gray-900 font-semibold text-sm">{{ number_format($painting->dimensions_with_frame, 2) }} cm</dd>
                        </div>
                        <div class="px-5 py-4 flex justify-between gap-4">
                            <dt class="text-gray-500 text-sm font-medium">Dimensions Without Frame</dt>
                            <dd class="text-gray-900 font-semibold text-sm">{{ number_format($painting->dimensions_without_frame, 2) }} cm</dd>
                        </div>
                        <div class="px-5 py-4 flex justify-between gap-4">
                            <dt class="text-gray-500 text-sm font-medium">Certificate of Authenticity</dt>
                            <dd class="text-gray-900 font-semibold text-sm text-right break-words">{{ $painting->certificate_of_authenticity }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-gray-900 font-semibold text-sm uppercase tracking-wider">Ownership & Purchase</h2>
                    </div>
                    <dl class="divide-y divide-gray-100">
                        @foreach([
                            ['Owned By', $painting->owned_by],
                            ['Purchased By', $painting->purchased_by],
                            ['Purchased From', $painting->purchased_from],
                            ['Paid By', $painting->paid_by],
                        ] as [$label, $value])
                            <div class="px-5 py-4 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                                <dt class="text-gray-500 text-sm font-medium">{{ $label }}</dt>
                                <dd class="text-gray-900 font-medium text-sm sm:text-right break-words">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('paintings.edit', $painting) }}" class="btn btn-primary btn-block-sm">
                        Edit Painting
                    </a>
                    <form action="{{ route('paintings.destroy', $painting) }}" method="POST" onsubmit="return confirm('Delete this painting?')" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block-sm w-full">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: painting image --}}
        <div class="lg:col-span-7 xl:col-span-7 order-1 lg:order-2">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden p-3 sm:p-4 lg:p-6">
                <div class="relative rounded-xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 ring-1 ring-gray-200">
                    @if($painting->photoUrl())
                        <img
                            src="{{ $painting->photoUrl() }}"
                            alt="{{ $painting->title }}"
                            class="w-full max-h-[70vh] object-contain mx-auto"
                        >
                    @else
                        <div class="w-full aspect-[4/3] flex flex-col items-center justify-center text-gray-400 p-8 text-center">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm">No photo uploaded</p>
                        </div>
                    @endif
                </div>
                <p class="text-center text-xs text-gray-400 mt-4">Painting preview — {{ $painting->title }}</p>
            </div>
        </div>
    </div>
@endsection
