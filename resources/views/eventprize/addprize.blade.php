@extends('layOut.default_model')

@section('contents')

    @include('layOut._errors')

<h1>添加试用抽奖奖品</h1>
<form action="{{route('evps.store')}}" method="post">

    <div class="form-group">
        <label for="t2">试用活动</label>
        <select class="form-control" name="events_id">
            <option value="{{$event->id}}" selected="selected">{{$event->title}}</option>
        </select>
    </div>

    <div class="form-group">
        <label for="t1">奖品名称</label>
        <input type="text" name="name" class="form-control" id="t1" value="{{old('name')}}"/>
    </div>

    <div class="form-group">
        <label for="t3">简洁</label>
       {{-- <input type="text" name="description" class="form-control" id="t1" value="{{old('description')}}"/>--}}
        <textarea name="description" class="form-control" id="t3">{{old('description')}}</textarea>
    </div>
    {{csrf_field()}}

    <button class="btn btn-primary">添加奖品</button>

</form>


@endsection