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
                <div>名前</div>
                <div><input type="text" name="name" placeholder="名前を記入してください" value="{{ $user['name'] }}"></div>
                <div>詳細</div>
                <div><textarea name="detail" placeholder="詳細を記入してください">{{ $user['detail'] }}</textarea></div>
                <div>アバターアイコン</div>
                <div><input type="file" name="avatar" accept=".png, .jpg, .jpeg"></div>

                <button type="submit">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection
