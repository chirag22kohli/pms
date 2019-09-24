@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Ecommerce</h2>

<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <section class="pricing-tables">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product Categories (12)</h5>
                       
                        <a href="{{ url('admin/product-categories')}}" class="btn btn-primary">Add/View Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products (11)</h5>
                     
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
                        <h5 class="card-title">Orders (22)</h5>
                   
                        <a href="#" class="btn btn-primary">View Orders</a>
                    </div>
                </div>
            </div>
           
        </div>
    </section>
    <!--// Error Page Info -->

</div>
<script>

    function upgradeNow(id) {
        location.href = 'upgradeNow?id=' + id;
    }
</script>
@endsection
