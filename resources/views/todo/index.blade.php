@extends('layouts.app')

@section('content')

@php
use App\Http\Controllers\TodoController
@endphp

<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <form action="{{ route('todo.index') }}" method="GET">
                <p class="bs-component"></p>
                <div class="navbar navbar-expand-lg navbar-light bg-light">
                    <select name="view_done" class="form-control">
                        <option value="">達成状況</option>
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
                    <select name="view_deadline" class="form-control">
                        <option value="">期限</option>
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
                    <input type="text" name="keyword" value="{{ $data['keyword'] }}" class="form-control" placeholder="検索キーワード">
                    <select name="sort_type" class="form-control">
                        <option value="">ソート</option>
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
                    <button type="submit" class="btn btn-primary btn-sm">表示条件設定</button>
                </div>
            </form>
        </div>
        <div class="col-lg-2">
            <a href="{{ route('todo.create') }}">新規作成</a>
        </div>
    </div>
    
    <p class="bs-component"></p>

    <div>
        <div class="col-lg-10">
            <table class="table table-hover">
                <thread>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ToDo</th>
                        <th scope="col">DeadLine</th>
                        <th scope="col">Info</th>
                        <th scope="col">Action</th>
                    </tr>
                </thread>                    

                @foreach($todos as $todo)

                    @if (!is_null($todo->done_at))
                        <tr class="table-dark">
                    @elseif ($todo->checkDeadline() === -1)
                        <tr class="table-danger">
                    @elseif ($todo->checkDeadline() === 0)
                        <tr class="table-warning">
                    @else
                        <tr class="table-default">
                    @endif
                        <th scope="row">
                            {{ $todo->id }}
                        </th>
                        <th scope="row">
                            <a href="{{ route('todo.show', ['id' => $todo->id]) }}">{{ $todo->title }}</a> 
                        </th>
                        <th scope="row">
                            {{ $todo->deadline_at }}
                        </th>
                        <th scope="row">
                            @if (!is_null($todo->done_at))
                                完了
                            @elseif ($todo->checkDeadline() === -1)
                                期限切れ
                            @elseif ($todo->checkDeadline() === 0)
                                期限間近
                            @endif
                        </th>
                        <th scope="row">
                            @if (is_null($todo->done_at))
                                <button class="done_btn" data-id="{{ $todo['id'] }}">完了</button>
                            @endif
                            <button class="delete_btn" data-id="{{ $todo['id'] }}">削除</button>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="col-lg-8">
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
