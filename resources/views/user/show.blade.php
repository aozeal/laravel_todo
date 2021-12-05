@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>名前</th>
                        <td scope="row">
                            {{ $user['name'] }}
                        </td>

                    </tr>
                    <tr>
                        <th>詳細</th>
                        <td>
                            {{ $user['detail'] }}
                        </td>                        
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            {{ $user['email'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>アイコン</th>
                        <td>
                            @if (!is_null($user['icon_path']))
                                <img src="{{ $user['icon_path'] }}" width=50 height=50>
                            @else
                                <img src="{{ asset('storage/avatar/default.png') }}" width=50 height=50>
                            @endif
                        </td>
                    </tr>
                </thread>
            </table>
            
        </div>
        <div>
            <a href="{{ route('user.edit', ['id' => $user['id']]) }}">編集</a><BR>
        </div>
    </div>
</div>
@endsection
