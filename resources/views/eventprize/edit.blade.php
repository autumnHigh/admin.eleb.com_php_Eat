@extends('layOut.default_model')

@section('contents')

<form action="{{route('evps.update',[$evp])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

<h1>抽奖活动表单</h1>
    <div class="form-group">
        <label for="t1">活动id</label>

        <input type="hidden" name="events_id" value="{{$evp->getEvent->id}}" class="form-control"/>
        <input type="text" name="title" value="{{$evp->getEvent->title}}" class="form-control" disabled="disabled"/>

        {{--<select name="events_id" class="form-control">

            <option value="{{$event->id}}" selected="selected">{{$event->title}}</option>

        </select>--}}
    </div>

    <div class="form-group">
        <label for="t2">奖品名称</label>
        <input type="text" name="name" class="form-control" id="t2" value="{{$evp->name}}"/>
    </div>

    <div class="form-group">
        <label for="description">奖品详情</label>
        <textarea name="description" class="form-control" id="description">{{$evp->description}}</textarea>
        {{--<input type="text" name="content" class="form-control" id="content" value="{{old('content')}}"/>--}}
    </div>

    {{--<div class="form-group">
        <label for="member_id">中奖商家账号id</label>
        <input type="text" name="member_id" class="form-control" id="member_id" value="{{old('member_id')}}"/>
    </div>--}}
    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">点击修改奖品</button>
</form>
@endsection