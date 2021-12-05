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

            <form action="{{ route('todo.store') }} " method="post">
                @csrf
                <div class="form-group">
                    <label for="titleInput">タイトル</label>
                    <input type="text" class="form-control" name="title" placeholder="タイトルを記入してください" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="detailInput">詳細</label>
                    <textarea name="detail" class="form-control" placeholder="詳細を記入してください">{{ old('detail') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="deadlineInput">期日</label>
                    <input type="datetime" class="form-control" name="deadline_at" placeholder="20XX-XX-XX XX:XX:XX" value="{{ old('deadline_at') }}">
                </div>
                <button type="submit" class="btn btn-primary">登録</button>
            </form>
        </div>
    </div>
</div>
@endsection
