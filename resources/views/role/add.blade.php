@extends('layOut.default_model')

@section('contents')

<form action="{{route('role.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>添加角色管理员</h1>
    <div class="form-group">
        <label for="name">角色管理员名</label>
        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}"/>
    </div>

    <div class="form-group">
        <label for="name">权限选项</label>
        @foreach($permissions as $permission)
           <input type="checkbox" name="permission[]" value="{{$permission->id}}" />{{$permission->name}}
        @endforeach
     </div>

    {{csrf_field()}}
    <button class="btn btn-primary btn-block">添加权限</button>
</form>
@endsection