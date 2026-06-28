@extends('layouts.print')

@section('title', 'Print Catalog')

@section('content')
    @if($paintings->isEmpty())
        <p class="print-empty">No paintings match the current filters.</p>
    @else
        @foreach($paintings as $painting)
            @include('paintings._print-sheet', ['painting' => $painting])
        @endforeach
    @endif
@endsection
