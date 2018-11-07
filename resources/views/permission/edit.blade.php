@extends('layOut.default_model')

@section('contents')

<form action="{{route('permission.update',[$permission])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>修改权限</h1>
    <div class="form-group">
        <label for="name">权限名称</label>
        <input type="text" name="name" class="form-control" id="name" value="{{$permission->name}}"/>
    </div>

    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">修改权限</button>
</form>
@endsection