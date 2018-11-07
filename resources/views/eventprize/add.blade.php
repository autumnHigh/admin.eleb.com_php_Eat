@extends('layOut.default_model')

@section('contents')

    @include('layOut._errors')

<h1>抽奖活动表单</h1>

        <table class="table table-condensed table-bordered table-hover">
            <tr class="active">
                <td>试用活动标题</td>
                <td>报名时间</td>
                <td>报名截止时间</td>
                <td>开奖时间</td>
                {{--<td>报名人数</td>--}}
                <td>操作</td>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->title}}</td>
                    <td>{{$event->signup_start}}</td>
                    <td>{{$event->signup_end}}</td>
                    <td>{{$event->prize_date}}</td>
                    <td>
                        <a href="{{route('evps.add',[$event])}}">添加奖品</a>
                    </td>
                </tr>
            @endforeach
        </table>
{{--{{method_field('PUT')}}
    {{csrf_field()}}--}}


@endsection