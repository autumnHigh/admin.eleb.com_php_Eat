@extends('layOut.default_model')

@section('contents')
    <!-- 引入 echarts.js -->
<script src="/js/echarts.min.js"></script>
    <h1>周订单报表</h1>
<table class="table table-bordered table-hover">
    <tr class="info">
        @foreach($date as $day)
            <th>{{$day}}</th>
            @endforeach
    </tr>

    <tr>
        @foreach($alls as $all)
            <td>{{$all}}</td>
            @endforeach
    </tr>

</table>

    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 800px;height:400px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: 'ECharts 入门示例'
            },
            tooltip: {},
            legend: {
                data:['销量']
            },
            xAxis: {

                data: @php echo json_encode(array_values($date)) @endphp//为什么就报错呢？
            },
            yAxis: {},
            series: [{
                name: '销量',
                type: 'line',

                data: {{$line}}
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>



@endsection