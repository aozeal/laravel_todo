@extends('layouts.app')

@section('content')

@php
use App\Http\Controllers\TodoController
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{ route('todo.index') }}" method="GET">
                <div>
                    達成状況
                    <select name="view_done">
                        <option value="">選択してください</option>
                        <option value="{{ TodoController::VIEW_DONE_WITHOUT_DONE }}" 
                        @if ($data['view_done'] === TodoController::VIEW_DONE_WITHOUT_DONE)
                            {{ 'selected' }}
                        @endif
                        >未完了のみ
                        </option>
                        <option value="{{ TodoController::VIEW_DONE_ONLY_DONE }}" 
                        @if ($data['view_done'] === TodoController::VIEW_DONE_ONLY_DONE)
                            {{ 'selected' }}
                        @endif
                        >完了のみ</option>
                        <option value="{{ TodoController::VIEW_DONE_WITH_DONE }}" 
                        @if($data['view_done'] === TodoController::VIEW_DONE_WITH_DONE)
                            {{ 'selected' }}
                        @endif
                        >両方</option>
                    </select>
                </div>
                <div>
                    期限
                    <select name="view_deadline">
                        <option value="">選択してください</option>
                        <option value="{{ TodoController::VIEW_DEADLINE_ALL }}" 
                        @if($data['view_deadline'] === TodoController::VIEW_DEADLINE_ALL)
                            {{ 'selected' }}
                        @endif
                        >すべて</option>
                        <option value="{{ TodoController::VIEW_DEADLINE_BEFORE_DEADLINE }}" 
                        @if($data['view_deadline'] === TodoController::VIEW_DEADLINE_BEFORE_DEADLINE)
                            {{ 'selected' }}
                        @endif
                        >期限前のみ</option>
                        <option value="{{ TodoController::VIEW_DEADLINE_CLOSE_DEADLINE }}" 
                        @if($data['view_deadline'] === TodoController::VIEW_DEADLINE_CLOSE_DEADLINE)
                            {{ 'selected' }}
                        @endif
                        >期限間近のみ</option>
                        <option value="{{ TodoController::VIEW_DEADLINE_AFTER_DEADLINE }}" 
                        @if($data['view_deadline'] === TodoController::VIEW_DEADLINE_AFTER_DEADLINE)
                            {{ 'selected' }}
                        @endif
                        >期限切れのみ</option>
                    </select>
                </div>
                <div>
                    検索キーワード
                    <input type="text" name="keyword" value="{{ $data['keyword'] }}">
                </div>
                <div>
                    ソート
                    <select name="sort_type">
                        <option value="">選択してください</option>
                        <option value="{{ TodoController::SORT_TYPE_CREATED_ASC }}" 
                        @if($data['sort_type'] === TodoController::SORT_TYPE_CREATED_ASC)
                            {{ 'selected' }}
                        @endif
                        >作成順（昇順）</option>
                        <option value="{{ TodoController::SORT_TYPE_CREATED_DESC }}" 
                        @if($data['sort_type'] === TodoController::SORT_TYPE_CREATED_DESC)
                            {{ 'selected' }}
                        @endif
                        >作成順（降順）</option>
                        <option value="{{ TodoController::SORT_TYPE_DEADLINE_ASC }}" 
                        @if($data['sort_type'] === TodoController::SORT_TYPE_DEADLINE_ASC)
                            {{ 'selected' }}
                        @endif
                        >期限日順（昇順）</option>
                        <option value="{{ TodoController::SORT_TYPE_DEADLINE_DESC }}" 
                        @if($data['sort_type'] === TodoController::SORT_TYPE_DEADLINE_DESC)
                            {{ 'selected' }}
                        @endif
                        >期限日順（降順）</option>                 
                    </select>
                </div>
                <button type="submit">表示条件設定</button>
            </form>
            <BR>

            @foreach($todos as $todo)
                <li>
                    {{ $todo->id }}
                    <a href="{{ route('todo.show', ['id' => $todo->id]) }}">{{ $todo->title }}</a> 
                    {{ $todo->deadline_at }}
                    @if (!is_null($todo->done_at))
                        <span>完了</span>
                    @elseif ($todo->checkDeadline() === -1)
                        <span>期限切れ</span>
                    @elseif ($todo->checkDeadline() === 0)
                        <span>期限間近</span>
                    @endif

                    @if (is_null($todo->done_at))
                        <button class="done_btn" data-id="{{ $todo['id'] }}">完了</button>
                    @endif
                    <button class="delete_btn" data-id="{{ $todo['id'] }}">削除</button>
                </li>
            @endforeach
        </div>
        <div>
            <a href="{{ route('todo.create') }}">新規作成</a>
        </div>
        <BR>
        <div class="col-md-8">
            @for ($i=1; $i<=$data['total_pages']; $i++)
                @if ($i == $data['page'])
                    {{ $i }}
                @else
                    <a href="{{ route('todo.index', ['page' => $i , 'view_deadline' => $data['view_deadline'], 'view_done' => $data['view_done'] , 'sort_type' => $data['sort_type'] , 'keyword' => $data['keyword']] ) }}">{{ $i }}</a> 
                @endif
            @endfor
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>

@endsection
