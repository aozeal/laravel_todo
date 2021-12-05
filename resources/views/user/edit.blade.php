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

            <form action="{{ route('user.update', ['id' => $user['id']]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="titleName">名前</label>
                    <input type="text" class="form-control" name="name" placeholder="名前を記入してください" value="{{ $user['name'] }}">
                </div>
                <div class="form-group">
                    <label for="titleName">詳細</label>
                    <textarea name="detail" class="form-control" placeholder="詳細を記入してください">{{ $user['detail'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="avatarIcon">アバターアイコン</label>
                    <input type="file" class="form-control-file" name="avatar" accept=".png, .jpg, .jpeg">
                </div>

                <button type="submit" class="btn btn-primary">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection
