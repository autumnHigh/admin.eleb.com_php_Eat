@extends('layOut.default_model')

@section('contents')

<form action="{{route('nav.twostore')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>添加二级菜单</h1>
    <div class="form-group">
        <label for="nav">名字</label>
        <input type="text" name="name" class="form-control" id="nav" value="{{old('name')}}"/>
    </div>

    <div class="form-group">
        <label for="pid">上级菜单</label>
        <select name="pid" class="form-control">
            @foreach($navs as $nav)
            <option value="{{$nav->id}}">{{$nav->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="url">地址/路由</label>
        <input type="text" name="url" class="form-control" id="url" value="{{old('url')}}"/>
    </div>


    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection