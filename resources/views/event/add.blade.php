@extends('layOut.default_model')

@section('contents')

<form action="{{route('event.store')}}" method="post" enctype="multipart/form-data">
    @include('vendor.ueditor.assets')
    @include('layOut._errors')

<h1>抽奖使用表单</h1>
    <div class="form-group">
        <label for="t1">抽奖试用名称</label>
        <input type="text" name="title" class="form-control" id="t1" value="{{old('title')}}"/>
    </div>



   {{-- <div class="form-group">
        <label for="content">内容</label>
        <textarea name="content" class="form-control" id="content">{{old('content')}}</textarea>
        --}}{{--<input type="text" name="content" class="form-control" id="content" value="{{old('content')}}"/>--}}{{--
    </div>
--}}

<!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <!-- 编辑器容器 -->
    <script id="container" name="content" type="text/plain"></script>




    <div class="form-group">
        <label for="signup_start">抽奖活动开始时间</label>
        <input type="date" name="signup_start" class="form-control" id="signup_start" value="{{old('signup_start')}}"/>
    </div>

    <div class="form-group">
        <label for="signup_end">抽奖活动结束时间</label>
        <input type="date" name="signup_end" class="form-control" id="signup_end" value="{{old('signup_end')}}"/>
    </div>

    <div class="form-group">
        <label for="prize_date">开奖日期</label>
        <input type="date" name="prize_date" class="form-control" id="prize_date" value="{{old('prize_date')}}"/>
    </div>

    <div class="form-group">
        <label for="signup_num">报名人数限制</label>
        <input type="text" name="signup_num" class="form-control" id="signup_num" value="{{old('signup_num')}}"/>
    </div>


    {{csrf_field()}}
    <button class="btn btn-primary btn-block">添加活动</button>
</form>
@endsection