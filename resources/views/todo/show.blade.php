@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <table>
                <thread>
                    <tr>
                        <th>タイトル</th>
                        <th>詳細</th>
                        <th>期日</th>
                        <th>完了日</th>
                    </tr>
                </thread>
                <tbody>
                    <tr>
                        <td scope="row">
                            {{ $todo['title'] }}
                        </td>
                        <td>
                            {{ $todo['detail'] }}
                        </td>
                        <td>
                            {{ $todo['deadline_at'] }}
                        </td>
                        <td>
                            {{ $todo['done_at'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div>
                {{----
                @if (!is_null($todo['done_at']))
                    達成済
                ---}}
                @if ($todo->checkDeadline() === -1)
                    期限切れ
                @elseif ($todo->checkDeadline() === 0)
                    期限間近！
                @endif
            </div>

        </div>
        <div>
            <a href="{{ route('todo.edit', ['id' => $todo['id']]) }}">編集</a><BR>
            <a href="{{ route('todo.index') }}">一覧</a>
        </div>
    </div>
</div>
@endsection
