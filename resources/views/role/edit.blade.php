@extends('layOut.default_model')

@section('contents')

<form action="{{route('role.update',[$role])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>修改角色管理员</h1>
    <div class="form-group">
        <label for="name">角色管理员名</label>
        <input type="text" name="name" class="form-control" id="name" value="{{$role->name}}"/>
    </div>

    <div class="form-group">
        <label for="name">权限选项</label>
        @foreach($pers as $per)

                @if(in_array($per->id,$permiss))
                    <input type="checkbox" name="permission[]" value="{{$per->id}}" checked="checked"/>{{$per->name}}

                @else
                    <input type="checkbox" name="permission[]" value="{{$per->id}}" />{{$per->name}}

                @endif

        @endforeach
     </div>
    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">修改角色</button>
</form>
@endsection