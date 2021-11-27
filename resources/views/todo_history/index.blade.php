@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="navbar navbar-expand-lg navbar-light bg-light col-lg-10">

            日時（空の場合は現在の時刻）
            <form action="{{ route('todo_history.index') }}" method="GET">
                <input type="datetime" name="target_date" placeholder="20XX-XX-XX XX:XX:XX" value="{{ $target_date }}">
                <button type="submit">Go!</button>
            </form>
        </div>
    </div>
    <p class="bs-component"></p>
    <div class="row justify-content-center ">
        <div class="col-lg-10">
            <table class="table table-hover">
                <thread>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ToDo ID</th>
                        <th scope="col">ToDo</th>
                        <th scope="col">DeadLine</th>
                        <th scope="col">Info</th>
                    </tr>
                </thread>                    
                <thread>
                    @foreach($histories as $todo)
                        @if ($todo->deleted_at)
                            @continue
                        @endif
                        @if ($todo->done_at)
                            @continue
                        @endif

                        @if (!is_null($todo->done_at))
                            <tr class="table-dark">
                        @elseif ($todo->checkDeadline($target_date) === -1)
                            <tr class="table-danger">
                        @elseif ($todo->checkDeadline($target_date) === 0)
                            <tr class="table-warning">
                        @else
                            <tr class="table-default">
                        @endif
                            <td scope="row">
                                {{ $todo->id }}
                            </td>
                            <td scope="row">
                                {{ $todo->todo_id }}
                            </td>
                            <td scope="row">
                                <a href="{{ route('todo_history.show', ['id' => $todo->id, 'target_date' => $target_date]) }}"> 
                                    {{ $todo->title }}
                                </a>
                            </td>
                            <td scope="row">
                                {{ $todo->deadline_at }}
                            </td>
                            <td scope="row">
                                @if ($todo->checkDeadline($target_date) === -1)
                                    <span>期限切れ</span>
                                @elseif ($todo->checkDeadline($target_date) === 0)
                                    <span>期限間近</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </thread>

            </table>
        </div>

    </div>
</div>

@endsection
