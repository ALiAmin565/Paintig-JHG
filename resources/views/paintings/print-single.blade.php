@extends('layouts.print')

@section('title', 'Print — '.$painting->title)

@section('content')
    @include('paintings._print-sheet', ['painting' => $painting])
@endsection
