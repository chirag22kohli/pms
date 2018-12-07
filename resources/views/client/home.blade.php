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
        $.getJSON("http://localhost/pms/public/getPaidProjectGraphData", function (data) {
            console.log(data);
            $.each(data, function (key, value) {

                dataPoints.push({x: new Date(value[1], value[0]), y: parseInt(value[2])});
            });

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
                    xValueFormatString: "MMMM",
                    type: "spline",
                    dataPoints: dataPoints
                }]
        };
        var chart = new CanvasJS.Chart("chartContainer", options);




    });
</script>
@endsection
