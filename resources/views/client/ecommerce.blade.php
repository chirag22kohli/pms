@extends('layouts.client')

@section('content')

<!-- main-heading -->
<a href="#">Settings</a>
<h2 class="main-title-w3layouts mb-2 text-center">Ecommerce</h2>

<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->


    <?php if (!$connectStatus) { ?>
        <p>Note: <i>To create Paid projects / Use Ecommerce and recieve payouts please connect your stripe account with Chap.</i></p></br>
        <a class = "btn btn-success" href ="planinfo">Plan Info</a> 
    <?php } else { ?>
        <section class="pricing-tables">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Product Categories ({{$categoryCount}})</h5>

                            <a href="{{ url('admin/product-categories')}}" class="btn btn-primary">Add/View Categories</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Products ({{$productCount}})</h5>

                            <a href="{{ url('admin/products')}}" class="btn btn-primary">Add/View Products</a>
                        </div>
                    </div>
                </div>
            </div>
            </br> </br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Orders ({{$ordersCount}})</h5>

                            <a href="{{ url('admin/orders')}}" class="btn btn-primary">View Orders</a>
                        </div>
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Settings</h5>

                            <a href="{{ url('client/settings')}}" class="btn btn-primary">Settings</a>
                        </div>
                    </div>
                </div>

            </div>
            
            
        </section>
    <?php } ?>
    <!--// Error Page Info -->

</div>
<script>

    function upgradeNow(id) {
        location.href = 'upgradeNow?id=' + id;
    }
</script>
@endsection
