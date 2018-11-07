@extends('layOut.default_model')

@section('contents')

<form action="{{route('session.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>管理员登陆</h1>
    <div class="form-group">
        <label for="na1">管理员名字</label>
        <input type="text" name="name" class="form-control" id="na1" value="{{old('name')}}"/>
    </div>

   {{-- <div class="form-group">
        <label for="em1">邮件地址</label>
        <input type="email" name="email" class="form-control" id="em1" value="{{old('email')}}"/>
    </div>--}}

    <div class="form-group">
        <label for="p1">管理员密码</label>
        <input type="text" name="password" class="form-control" id="p1" value="{{old('password')}}"/>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember" value="1" @if(old('remember')) checked="checked" @endif> 下次自动登陆
        </label>
    </div>

    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection