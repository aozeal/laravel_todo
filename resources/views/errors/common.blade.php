@extends('layouts.app')

@section('content')
@php
    $message = $exception->getMessage();
    $status_code = $exception->getStatusCode();
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Sorry...
                </div>
                <div class="card-body">
                    {{ $status_code }} : {{ $message }}
                </div>
                <div class="card-body">
                    <a class="btn btn-primary" href="{{ url('/') }}" role="button">トップに戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
