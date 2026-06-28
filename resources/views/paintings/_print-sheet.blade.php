@php
    $withFrame = $painting->printDimensionsPair($painting->width_with_frame, $painting->height_with_frame);
    $withoutFrame = $painting->printDimensionsPair($painting->width_without_frame, $painting->height_without_frame);
    $notesText = $painting->notes->pluck('body')->filter()->implode('; ');
@endphp

<article class="print-sheet">
    <div class="print-sheet__frame">
        <header class="print-sheet__header">
            <span class="print-sheet__item-no">Item No.: {{ $painting->id }}</span>
        </header>

        <div class="print-sheet__image-wrap">
            @if($painting->photoUrl())
                <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="print-sheet__image">
            @else
                <div class="print-sheet__image-placeholder">No image</div>
            @endif
        </div>

        <table class="print-sheet__table">
            <tbody>
                <tr>
                    <th class="print-sheet__label" rowspan="2">Dimensions</th>
                    <td class="print-sheet__sub-label">With frame :</td>
                    <td class="print-sheet__value">{!! $withFrame ?: '&nbsp;' !!}</td>
                </tr>
                <tr>
                    <td class="print-sheet__sub-label">Without frame :</td>
                    <td class="print-sheet__value">{!! $withoutFrame ?: '&nbsp;' !!}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">Painter</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value">{{ $painting->painter_name ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">Title</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value">{{ $painting->title ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">Medium</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value">{{ $painting->media ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">Production Year</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value">{{ $painting->production_year ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">Price</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value">{{ $painting->printPriceLabel() }}</td>
                </tr>
                <tr>
                    <th class="print-sheet__label">N.B.</th>
                    <td class="print-sheet__colon">:</td>
                    <td class="print-sheet__value print-sheet__value--notes">{!! $notesText ? e($notesText) : '&nbsp;' !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</article>
