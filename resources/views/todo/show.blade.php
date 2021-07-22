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
            {{--
            <div>
                {{ $now = DateTime('Asia/Tokyo') }}
                {{ $deadline = new DateTime($todo['deadline_at'], new DateTimeZone('Asia/Tokyo')) }}
                {{ $interval = $deadline->diff($now) }}
                @if (!is_null($todo['done_at']))
                    達成済
                @elseif (is_null($todo['deadline_at']))

                @elseif ($now > $deadline)
                    期限切れ
                @elseif ($interval->d < 1)
                    期限間近！
                @endif
            </div>
            --}}
        </div>
        <div>
            <button><a href="{{ route('todo.edit', ['id' => $todo['id']]) }}">編集</a>
            </button>
        </div>
    </div>
</div>
@endsection
