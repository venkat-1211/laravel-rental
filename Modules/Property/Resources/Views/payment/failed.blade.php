@extends('shared::layouts.master')

@section('title', 'Payment Failed')

@section('content')
<div class="container">
    <h3 class="text-danger">Payment Failed</h3>
    <p>{{ $error }}</p>
    <a href="{{ route('phonepe.initiate', ['property' => request()->property_id ?? 1]) }}" class="btn btn-primary">Try Again</a>
</div>
@endsection