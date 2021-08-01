@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @foreach($todos as $todo)
                <li>
                    {{ $todo->id }}
                    <a href="{{ route('todo.show', ['id' => $todo->id]) }}">{{ $todo->title }}</a> 
                    {{ $todo->deadline_at }}
                    @if ($todo->checkDeadline() === -1)
                        <span>期限切れ</span>
                    @elseif ($todo->checkDeadline() === 0)
                        <span>期限間近</span>
                    @endif
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

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>

@endsection
