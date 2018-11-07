@extends('layOut.default_model')

@section('contents')

<form action="{{route('shopcategories.store')}}" method="post">

    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">

    <!--引入JS-->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    @include('layOut._errors')
    <div class="form-group">
        <label for="tit">分类名</label>
        <input type="text" name="name" class="form-control" id="tit" value="{{old('name')}}"/>
    </div>


    <div class="form-group">
        <label for="img">分类图片</label>
        <input type="text" id="img" name="img">
    </div>

    <!--dom结构部分-->
    <div id="uploader-demo">
        <!--用来存放item-->
        <div id="fileList" class="uploader-list"></div>
        <div id="filePicker">选择图片</div>

    </div>
    <img id="pic" src="{{old('img')}}" width="300px"/>

    <div class="radio">
        <label for="optionsRadios">
            <input type="radio" name="status" id="optionsRadios1" value="1" checked>
            显示
        </label>
        <label for="optionsRadios1">
            <input type="radio" name="status" id="optionsRadios1" value="0">
            不显示
        </label>
    </div>

    {{csrf_field()}}
    <button class="btn btn-primary btn-block">增加</button>
</form>
@endsection

@section('javascript')
    <script>
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            //swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: '{{route('upload')}}',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //传送token
            formData:{
                _token:"{{csrf_token()}}",
            },


        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function(file,response) {
            //$( '#'+file.id ).addClass('upload-state-done');
            //将上穿成功的图片，显示在页面上
            //console.log(response);
            //上传的图片回显到指定的位置
            $('#pic').attr('src',response.path);
            //将上传之后的图片地址存放到图片输入框中，在进行数据库的插入
            $('#img').val(response.path);
        });

    </script>
@endsection