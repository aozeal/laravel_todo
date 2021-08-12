@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            Access Token：<BR>
            {{ $token }}
    </div>
    <div class="row justify-content-center">
        ・最初の「数字|」の文字はトークンではありません<BR>
        ・TOKENはこの画面で表示するたびに変わり、前のは使えなくなります<BR>
    </div>
</div>
@endsection
