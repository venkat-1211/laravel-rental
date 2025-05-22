@extends('shared::layouts.master')

@section('title', 'Payment Success')

@section('content')
<div class="container">
    <h3 class="text-success">Payment Response Received</h3>
    <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection