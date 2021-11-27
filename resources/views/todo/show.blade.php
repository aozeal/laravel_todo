@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>タイトル</th>
                        <td scope="row">
                            {{ $todo['title'] }}
                        </td>

                    </tr>
                    <tr>
                        <th>詳細</th>
                        <td>
                            {{ $todo['detail'] }}
                        </td>                        
                    </tr>
                    <tr>
                        <th>期日</th>
                        <td>
                            <div>
                                {{ $todo['deadline_at'] }}
                            </div>                        
                        </td>
                    </tr>
                    <tr>
                        <th>完了日</th>
                        <td>
                            <div>
                                {{ $todo['done_at'] }}
                            </div>
                            <div>
                                @if (!is_null($todo['done_at']))
                                    達成済
                                @elseif ($todo->checkDeadline() === -1)
                                    期限切れ
                                @elseif ($todo->checkDeadline() === 0)
                                    期限間近！
                                @endif
                            </div>
                        </td>
                    </tr>
                </thread>
            </table>
            

        </div>
        <div class="col-md-2">
            <a href="{{ route('todo.edit', ['id' => $todo['id']]) }}">編集</a><BR>
            <a href="{{ route('todo.index') }}">一覧</a>
        </div>
    </div>
</div>
@endsection
