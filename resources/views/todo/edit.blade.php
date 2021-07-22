@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('todo.update', ['id' => $todo['id']]) }}" method="post">
                @csrf
                @method('put')
                <div>タイトル</div>
                <div><input type="text" name="title" placeholder="タイトルを記入してください" value="{{ $todo['title'] }}"></div>
                <div>詳細</div>
                <div><textarea name="detail" placeholder="詳細を記入してください">{{ $todo['detail'] }}</textarea></div>
                <div>期日</div>
                <div><input type="datetime" name="deadline_at" placeholder="20XX-XX-XX XX:XX:XX" value="{{ $todo['deadline_at'] }}"></div>
                <button type="submit">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection
