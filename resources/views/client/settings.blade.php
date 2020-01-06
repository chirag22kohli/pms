@extends('layouts.client')

@section('content')

<!-- main-heading -->

<h2 class="main-title-w3layouts mb-2 text-center">Settings</h2>
</br>

<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->

    <section class="pricing-tables">
        <div class="form-group">
            <div class="form-group row">
                <label class="control-label col-sm-2">Delivery Charges</label>
                <input type="text" value ="0" class="form-control col-sm-6" name ="name" placeholder="Enter username" required="">
            </div>
        </div>
        
        
        <button class="btn btn-success">Update</button>
    </section>
</div>
<script>

    function upgradeNow(id) {
        location.href = 'upgradeNow?id=' + id;
    }
</script>
@endsection
