@extends('layOut.default_model')

@section('contents')
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>分类名称</th>
        <th>分类图片</th>
        <th>是否显示</th>
        <th>操作</th>
    </tr>
    @foreach($cates as $cate)
        <tr>
            <td>{{$cate->id}}</td>
            <td>{{$cate->name}}</td>
            <td><img src="{{$cate->img}}" width="70px"/></td>
            <td>{{$cate->status==1?'显示':'不显示'}}</td>
            <td>


                <a href="{{route('shopcategories.edit',['cate'=>$cate])}}" class="btn btn-success">编辑</a>

                <form action="{{route('shopcategories.destroy',[$cate])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{$cates->links()}}

@endsection