@extends('layOut.default_model')

@section('contents')

<form action="{{route('user.update',[$user])}}" method="post" enctype="multipart/form-data">
    @include('layOut._errors')
    <div class="form-group">
        <label for="tit">商户账号名</label>
        <input type="text" name="name" class="form-control" id="tit" value="{{$user->name}}"/>
    </div>

    <div class="form-group">
        <label for="pwd">商户密码</label>
        <input type="text" name="password" class="form-control" id="pwd" value="{{$user->password}}"/>
    </div>



    <div class="form-group">
        <label for="ema">商户邮件地址</label>
        <input type="text" name="email" class="form-control" id="ema" value="{{$user->email}}"/>
    </div>


    <div class="form-group">
        <label for="shop_na">商户店铺名称</label>
        <input type="text" name="shop_id" value="{{$user->shop_id}}"/>
        <input type="text" name="shop_name" class="form-control" id="shop_na" value="{{$user->getInfo->shop_name}}"/>
    </div>


    {{method_field('PUT')}}
    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection