@props(['variant' => 'default', 'size' => 'md'])

@php
    $variants = [
        'default' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200'],
        'primary' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
        'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200'],
        'warning' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200'],
        'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200'],
        'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200'],
        'inactive' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200'],
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];

    $variantData = $variants[$variant] ?? $variants['default'];
    $sizeStyle = $sizes[$size] ?? $sizes['md'];
@endphp

<span class="inline-flex items-center gap-1 {{ $variantData['bg'] }} {{ $variantData['text'] }} {{ $sizeStyle }} rounded-full font-semibold border border-opacity-20 {{ $variantData['border'] }}">
    {{ $slot }}
</span>
