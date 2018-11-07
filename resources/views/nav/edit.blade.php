@extends('layOut.default_model')

@section('contents')

<form action="{{route('nav.update',[$nav])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>修改菜单</h1>
    <div class="form-group">
        <label for="nav">名字</label>
        <input type="text" name="name" class="form-control" id="nav" value="{{$nav->name}}"/>
    </div>

    <div class="form-group">
        <label for="pid">上级菜单</label>
        <select name="pid" class="form-control">
            @foreach($navs as $na)
                @if($na->id == $nav->pid)
                    <option value="{{$na->id}}" selected="selected">{{$na->name}}</option>
                @else
                    <option value="{{$na->id}}">{{$na->name}}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="url">地址/路由</label>
        <select class="form-control" name="url">
            @foreach($permissions as $permission)
                @if($permission->name == $nav->url)
                    <option value="{{$permission->name}}" selected="selected">{{$permission->name}}</option>
                @else
                    <option value="{{$permission->name}}">{{$permission->name}}</option>
                @endif
            @endforeach
        </select>

    </div>
    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">点击修改</button>
</form>
@endsection