@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @foreach($todos as $todo)
                <li>
                    {{ $todo->id }}
                    <a href="{{ route('todo.show', ['id' => $todo->id]) }}">{{ $todo->title }}</a> 
                    <td>{{ $todo->deadline_at }}</td>
                    <button class="done_btn" data-id="{{ $todo['id'] }}">完了</button>
                    <button class="delete_btn" data-id="{{ $todo['id'] }}">削除</button>
                </li>
            @endforeach
        </div>
        <div>
            <a href="{{ route('todo.create') }}">新規作成</a>
        </div>
    </div>
</div>
@endsection
