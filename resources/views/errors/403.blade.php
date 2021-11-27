@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                @if ($error_code)
                    <div class="card-body">
                        {{ $error_code }}
                    </div>
                @endif
                <div class="card-body">
                    403
                </div>
                <div class="card-body">
                    Forbidden
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
