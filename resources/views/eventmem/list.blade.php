@extends('layOut.default_model')

@section('contents')
    @auth
<table class="table table-bordered table-hover">
    <tr class="info">
        <th>id</th>
        <th>活动名称</th>
        <th>报名人员名称</th>
        <th>操作</th>
    </tr>

    @foreach($evembs as $emes)
        <tr>
        <td>{{$emes->id}}</td>
        <td>{{$emes->getEvent->title}}</td>
        <td>{{$emes->getEventPrize->name}}</td>
            <td>
                <a href="#">报名详情</a>
            </td>
        </tr>
    @endforeach

</table>
{{--{{$evembs->links()}}--}}
    @endauth

    @guest
        <a href="{{route('session.create')}}">登陆操作</a>
    @endguest

@endsection