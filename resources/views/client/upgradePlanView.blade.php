@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Upgrade to a New Plan.</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <section class="pricing-tables">
        <h4 class="tittle-w3-agileits mb-4 mt-3"></h4>
        <?php if (count($getSimilarPlans) > 0) { ?>
            <div class="card-deck text-center row">

                <?php foreach ($getSimilarPlans as $planInfo) {
                    ?>
                    <div class="card box-shadow col-xl-3 col-md-6">
                        <div class="card-header">
                            <h4 class="py-md-4 py-xl-3 py-2"><?= $planInfo->name; ?></h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title pricing-card-title">
                                <span class="align-top">$</span><?= $planInfo->price; ?>
                                <small class="text-muted">/ <?= $planInfo->price_type; ?></small>
                            </h5>
                            <ul class="list-unstyled mt-3 mb-4">

                                <?php if ($planInfo->type == 'size') { ?>
                                    <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $planInfo->max_trackers }} MB Storage</li> 

                                <?php } else { ?>

                                    <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>{{ $planInfo->max_trackers }} Trackers</li> 

                                    <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Unlimited Storage</li> 

                                <?php } ?>
                                <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>True AR Experience</li>
                                <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>Reports</li>
                            </ul>
                            <button type="button" onclick ="upgradeNow('<?= base64_encode($planInfo->id) ?>')" class="btn btn-lg btn-block btn-outline-primary py-2" data-toggle="modal" data-target="">Upgrade Now</button>
                        </div>
                    </div>
                <?php } ?>

            </div>
           <?php } else {
            ?>
            <div class = "outer-w3-agile mt-12">
                <h4 class="tittle-w3-agileits mb-4">You are currently using the most advanced and upgraded Plan!</h4>
            </div>
        <?php } ?>
    </section>
    <!--// Error Page Info -->

</div>
<script>

    function upgradeNow(id) {
        location.href = 'upgradeNow?id=' + id;
    }
</script>
@endsection
