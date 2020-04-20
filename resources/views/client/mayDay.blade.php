@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">May Day! May Day! May Day!</h2>

<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <section class="pricing-tables">
        <img src = "{{url('images/lost.jpg')}}">
    </section>
    <!--// Error Page Info -->

</div>
<script>

    function upgradeNow(id) {
        location.href = 'upgradeNow?id=' + id;
    }
</script>
@endsection
