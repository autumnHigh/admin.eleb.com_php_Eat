@extends('layOut.default_model')

@section('contents')

<form action="{{route('admin.update',[$admin])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>管理员信息修改</h1>
    <div class="form-group">
        <label for="na1">管理员名字</label>
        <input type="text" name="name" class="form-control" id="na1" value="{{$admin->name}}"/>
    </div>

    <div class="form-group">
        <label for="em1">邮件地址</label>
        <input type="email" name="email" class="form-control" id="em1" value="{{$admin->email}}"/>
    </div>

    <div class="form-group">
        <label for="p1">管理员旧密码</label>
        <input type="text" name="oldpassword" class="form-control" id="p1"/>
    </div>

    <div class="form-group">
        <label for="p2">管理员新密码</label>
        <input type="text" name="newPassword" class="form-control" id="p2"/>
    </div>

    <div class="form-group">
        <label for="p2">管理员确认新密码</label>
        <input type="text" name="newPassword_confirmation" class="form-control" id="p2"/>
    </div>

    <div class="form-group">
        <label for="roles">角色:</label>
        @foreach($roles as $role)
           {{-- @if(in_array($role->id,$mhr))
                <input type="checkbox" name="roles[]" id="roles" checked="checked" value="{{$role->id}}"/>{{$role->name}}
            @else
                <input type="checkbox" name="roles[]" id="roles" value="{{$role->id}}"/>{{$role->name}}
            @endif--}}
                    {{--如果回显的管理员的数据有默认角色，就默认勾选中。循环全部的角色信息   --}}
            <input type="checkbox" name="roles[]" id="roles" value="{{$role->id}}" @if($admin->hasRole($role->name)) checked="checked" @endif/>{{$role->name}}


        @endforeach

    </div>

    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">点击修改</button>
</form>
@endsection