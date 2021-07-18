@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @foreach($todos as $todo)
                <tr>
                    <td>{{ $todo->id }}</td>
                    <td><a href="/todo/{{ 'todo->id' }}">{{ $todo->title }}</a></td>
                    <td>{{ $todo->detail }}</td>
                </tr>
            @endforeach
        </div>
    </div>
</div>
@endsection
