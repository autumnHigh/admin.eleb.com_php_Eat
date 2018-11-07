@extends('layOut.default_model')

@section('contents')

<form action="{{route('nav.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>添加菜单</h1>
    <div class="form-group">
        <label for="nav">名字</label>
        <input type="text" name="name" class="form-control" id="nav" value="{{old('name')}}"/>
    </div>

    <div class="form-group">
        <label for="pid">上级菜单</label>
            <select name="pid" class="form-control">
                @foreach($navs as $nav)
                    @if($nav->pid==0)
                        <option value="{{$nav->id}}" selected="selected">{{$nav->name}}</option>
                    @else
                        <option value="{{$nav->id}}">{{$nav->name}}</option>
                    @endif
                @endforeach
            </select>
    </div>

    <div class="form-group">
        <label for="url">地址/路由</label>
        <select class="form-control" name="url">
            @foreach($permissions as $permission)
                <option value="{{$permission->name}}">{{$permission->name}}</option>
            @endforeach
        </select>

    </div>


    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection