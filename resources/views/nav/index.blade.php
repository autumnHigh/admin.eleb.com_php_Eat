@extends('layOut.default_model')

@section('contents')
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>菜单名称</th>
        <th>菜单节点</th>
        <th>操作</th>
    </tr>
    @foreach($navs as $nav)
        <tr>
            <td>{{$nav->id}}</td>
            <td>{{$nav->name}}</td>
            <td>{{$nav->url}}</td>

            <td>
                @if($nav->url==null)
                    <button class="btn btn-warning" disabled="disabled">顶级菜单</button>
                @else
                    <a href="{{route('nav.edit',[$nav])}}" class="btn btn-primary">编辑</a>
                @endif

                <form action="{{route('nav.destroy',[$nav])}}" method="post">
                     {{method_field('DELETE')}}
                    {{csrf_field()}}
                    <button class="btn btn-danger" disabled="disabled">删除菜单</button>
                 </form>

            </td>

        </tr>
    @endforeach
</table>
{{$navs->links()}}

@endsection