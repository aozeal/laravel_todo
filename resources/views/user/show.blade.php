@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <table>
                <thread>
                    <tr>
                        <th>名前</th>
                        <th>詳細</th>
                        <th>メールアドレス</th>
                    </tr>
                </thread>
                <tbody>
                    <tr>
                        <td scope="row">
                            {{ $user['name'] }}
                        </td>
                        <td>
                            {{ $user['detail'] }}
                        </td>
                        <td>
                            {{ $user['email'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <img src="{{ asset('storage/avatar/' . $user['icon_path']) }}" width=50 height=50>
            
        </div>
        <div>
            <a href="{{ route('user.edit', ['id' => $user['id']]) }}">編集</a><BR>
        </div>
    </div>
</div>
@endsection
