@extends('layOut.default_model')

@section('contents')

<form action="{{route('admin.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>管理员注册</h1>
    <div class="form-group">
        <label for="na1">管理员名字</label>
        <input type="text" name="name" class="form-control" id="na1" value="{{old('name')}}"/>
    </div>

    <div class="form-group">
        <label for="em1">邮件地址</label>
        <input type="email" name="email" class="form-control" id="em1" value="{{old('email')}}"/>
    </div>

    <div class="form-group">
        <label for="p1">管理员密码</label>
        <input type="text" name="password" class="form-control" id="p1" value="{{old('password')}}"/>
    </div>

    <div class="form-group">
        <label for="roles">角色:</label>
        @foreach($roles as $role)
            <input type="checkbox" name="roles[]" id="roles" value="{{$role->id}}"/>{{$role->name}}
        @endforeach

    </div>


    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection