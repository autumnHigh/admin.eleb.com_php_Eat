@extends('layOut.default_model')

@section('contents')

<form action="{{route('audit.update',[$audit])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')

    <div class="form-group">
        <label for="na1">商家名</label>
        <input type="text" name="name" class="form-control" id="na1" value="{{$audit->shop_name}}"/>
    </div>

   {{-- <div class="form-group">
        <label for="em1">商家邮箱</label>
        <input type="email" name="email" class="form-control" id="em1" value="{{$audit->detailInfo->email}}"/>
    </div>--}}

    <div class="form-group">
        <label for="exampleInputFile">店铺图片</label>
        <input type="file" id="exampleInputFile" name="cover">
        <img src="{{\Illuminate\Support\Facades\Storage::url($audit->shop_img)}}" width="100px"/>
    </div>

  {{--  <div class="form-group">
        <label for="na1">审核状态</label>
        <select name="status" class="form-control">
            @if($audit->status==1)
            <option value="1" selected="selected">正常</option>
            @elseif($audit->status==0)
                <option value="0" selected="selected">审核中</option>
            @else
                <option value="-1" selected="selected">禁用</option>
            @endif
        </select>
    </div>--}}


    <div class="radio">状态	：
        <label for="status1">
            <input type="radio" name="status" id="status1" value="1" checked>
            正常
        </label>
        <label for="status2">
            <input type="radio" name="status" id="status2" value="0">
            待审核
        </label>

        <label for="status3">
            <input type="radio" name="status" id="status3" value="-1">
            禁用
        </label>
    </div>


    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection