@extends('layOut.default_model')

@section('contents')
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>商家名称</th>
        <th>商家持有人名称</th>
        <th>商家图片</th>
        <th>商家邮件地址</th>
        <th>商铺状态</th>
        <th>操作</th>
    </tr>
    @foreach($audits as $audit)
        <tr>
            <td>{{$audit->id}}</td>
            <td>{{$audit->detailInfo->name}}</td>
            <td>{{$audit->shop_name}}</td>

            <td><img src="{{$audit->shop_img}}" width="100px"/></td>

            <td>{{$audit->detailInfo->email}}</td>
            <td>
                @if($audit->status==1)
                    正常
                @elseif($audit->status==0)
                    审核中
                @else
                    禁用
                @endif
            </td>

            <td>

                <form action="{{route('audit.update',['audit'=>$audit])}}" method="post">
                    {{method_field('PUT')}}
                    {{csrf_field()}}
                    <button class="btn btn-primary">审核通过</button>
                </form>


                <form action="{{route('audit.destroy',[$audit])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                <button class="btn btn-warning">删除审核</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{--{{$audits->links()}}--}}

@endsection