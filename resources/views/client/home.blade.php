@extends('layouts.client')

@section('content')


<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Welcome to Chap</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <div class ="row">
            <div class = "col-md-6">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>

            </div>
            <div class = "col-md-6">

            </div>
        </div>
        <div class ="row">
            <div class = "col-md-6">

            </div>
            <div class = "col-md-6">

            </div>
        </div>
    </div>
    <!--// Error Page Info -->

</div>

<script type="text/javascript">
    $(document).ready(function () {
        var dataPoints = [];
        $.getJSON("getPaidProjectGraphData", function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value['Month(created_at)']);
                dataPoints.push({x: new Date(value['Year(created_at)'], value['Month(created_at)']), y: value['sum(paid_price)']});
            });
            console.log(options);
            chart.render();
        });
        var options = {
            animationEnabled: true,
            title: {
                text: "Monthly Earning (Paid Projects)"
            },
            axisX: {
                valueFormatString: "MMM"
            },
            axisY: {
                title: "Sales (in SGD)",
                prefix: "$",
                includeZero: false
            },
            data: [{
                    yValueFormatString: "$#,###",
                    xValueFormatString: "M",
                    type: "spline",
                    dataPoints: dataPoints
                }]
        };
        var chart = new CanvasJS.Chart("chartContainer", options);




    });
</script>
@endsection
