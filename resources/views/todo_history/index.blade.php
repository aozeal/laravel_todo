@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div>日時（空の場合は現在の時刻）</div>
            <form action="{{ route('todo_history.index') }}" method="GET">
                <div><input type="datetime" name="target_date" placeholder="20XX-XX-XX XX:XX:XX" value="{{ $target_date }}"></div>
                <button type="submit">Go!</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div>
        @foreach($histories as $todo)
            @if ($todo->deleted_at)
                @continue
            @endif
            @if ($todo->done_at)
                @continue
            @endif
            <li>
                {{ $todo->id }}
                ({{ $todo->todo_id }})
                <a href="{{ route('todo_history.show', ['id' => $todo->id, 'target_date' => $target_date]) }}">{{ $todo->title }}</a> 
                {{ $todo->deadline_at }}
                @if ($todo->checkDeadline($target_date) === -1)
                    <span>期限切れ</span>
                @elseif ($todo->checkDeadline($target_date) === 0)
                    <span>期限間近</span>
                @endif
            </li>
        @endforeach
        </div>
    </div>
</div>

@endsection
