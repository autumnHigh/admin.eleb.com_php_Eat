@extends('layOut.default_model')

@section('contents')
    @include('vendor.ueditor.assets')
<form action="{{route('active.store')}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

    <!--##### ueditor #######-->


<h1>活动添加页面</h1>
    <div class="form-group">
        <label for="na1">活动名称</label>
        <input type="text" name="title" class="form-control" id="na1" value="{{old('title')}}"/>
    </div>


        <div class="form-group">
            <label for="na1">活动内容</label>

            <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container');
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                });
            </script>

            <!-- 编辑器容器 -->
            <script id="container" name="content" type="text/plain"></script>

        </div>

        <div class="form-group">
        <label for="s1">活动开始时间</label>
        <input type="date" name="start_time" class="form-control" id="s1" value="{{old('start_time')}}"/>
    </div>

    <div class="form-group">
        <label for="e1">活动结束时间</label>
        <input type="date" name="end_time" class="form-control" id="e1" value="{{old('end_time')}}"/>
    </div>

    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection