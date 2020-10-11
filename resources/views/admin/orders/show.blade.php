@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')

@section('content')
<?php
$orderStatus = ['Recieved', 'Ready', 'Collected'];
?>
<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Order {{ $order->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/admin/orders') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>


                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Order ID</th><td>#{{ $order->id }}</td>
                                </tr>
                                <tr><th> Amount </th>
                                    <td> ${{ $order->amount }} </td></tr>
                                <tr><th> User Email </th><td> <b>{{ $order->user_details->email }} </b></td></tr>
                                <tr><th> Table Number </th>
                                    <td> {{ $order->table_number }} </td></tr>

                                <tr><th> Order Status </th>
                                    <td> <select onchange="updateStatus(this.value,<?= $order->id ?>)"> <?php foreach ($orderStatus as $status) { ?>
                                                <option value = "<?= $status ?>" <?php
                                                if ($order->status == $status) {
                                                    echo "selected";
                                                }
                                                ?> >Order <?= $status ?></option>
<?php }
?>
                                        </select></td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            </br></br>

            <div class = "row">
                <div class = "col-md-12">
                    <div class="card">
                        <div class="card-header" style="background:#4CAF50;color:#fff">Products</div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th><th>Price</th><th>Attributes</th> <th>Quantity</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->order_details as $ord)
                                        <tr>
                                            <td>{{ $ord->product_details->name   }}</td>
                                            <td>${{ $ord->price  }}</td>
                                            <td>

                                                <?php
                                                $attributes = json_decode($ord->attributes);
                                                $attributeOptions = json_decode($ord->attribute_options);
                                                $i = 0;
                                                foreach ($attributes as $attribute) {
                                                    echo $attribute . ' - ' . '<b>' . $attributeOptions[$i] . '</b>' . "</br>";
                                                    $i++;
                                                }
                                                ?>





                                            </td>
                                            <td>{{ $ord->quantity }}</td>



                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>


              
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(status, order_id) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/updateOrderStatus')}}",
            data: {
                id: order_id,
                status: status
            }
        }).done(function (data) {
            $.alert(data);
        });
    }
</script>
@endsection
