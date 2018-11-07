@extends('layOut.default_model')

@section('contents')

<form action="{{route('permission.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>添加权限</h1>
    <div class="form-group">
        <label for="name">权限名称</label>
        <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}"/>
    </div>

    {{csrf_field()}}
    <button class="btn btn-primary btn-block">添加权限</button>
</form>
@endsection