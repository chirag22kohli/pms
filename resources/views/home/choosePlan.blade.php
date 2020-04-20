@extends('layouts.home')

@section('content')
<style>
    .container-page h3,  .container-page label{
        color:#fff;
    }
</style>
<?php if (count($plans) > 0) { ?>
    <section id="pricing" class="section pricing pricing-1 bg-overlay bg-overlay-theme bg-parallex">
        <div class="bg-section">
            <img src="{{ asset('home/images/background/bg-4.jpg') }}" alt="background">
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
                        <h2 class="heading--title text-white">Choose Pricing Plan</h2>
                        <p class="heading--desc text-white">Pricing plans all made for your needs!</p>
                    </div>
                </div>
                <!-- .col-md-6 end -->
            </div>
            <!-- .row end -->
            <div class=" row carousel" data-slide="3" data-slide-res="2" data-autoplay="true" data-nav="false" data-dots="false" data-space="30" data-loop="true" data-speed="10000">
                <!-- Pricing Packge #1
                ============================================= -->
                <?php foreach ($plans as $plan) { ?>
                    <div class=" col-xs-12 col-sm-12 col-md-12 price-table wow fadeInUp" data-wow-duration="1s">
                        <div class="pricing-panel">
                            <!--  Pricing heading  -->
                            <div class="pricing--heading text--center">
                                <h4><?= $plan->name ?></h4>
                                <div class="pricing--heading">
                                    <p>$<?= $plan->price ?></p>
                                    <div class="pricing--desc">
                                        <ul class="list-unstyled">
                                            <?php if ($plan->is_ecom == '1') { ?>
                                                <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Includes Ecommerce</li> 

                                            <?php } ?>
                                            <?php if ($plan->type == 'size') { ?>
                                                <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $plan->max_trackers }} MB Storage</li> 

                                            <?php } else { ?>

                                                <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $plan->max_trackers }} Trackers</li> 

                                                <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> Unlimited Storage</li> 

                                            <?php } ?>
                                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> Reports</li>
                                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> True AR Experience</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--  Pricing body  -->
                            <div class="pricing--body">
                                <input type="hidden" id ="csr" value="{{ csrf_token() }}">
                                <a class="btn btn--white btn--bordered" onclick = "choosePlan('{{ $plan->id }}')">Get Started</a>
                            </div>
                            <!--  Pricing Body  -->
                        </div>

                    </div>
                <?php } ?>
                <!-- .pricing-table End -->


                <!-- .pricing-table End -->
            </div>
            <!-- .row end -->
        </div>
        <!-- .container end -->
    </section>
<?php } ?>

<script>
    function choosePlan(id){
    $.ajax({
    url: "choosePlan",
            method: 'post',
            headers: {
            'X-CSRF-TOKEN': $('#csr').val()
            },
            data: {plan_id: id},
            cache: false,
            beforeSend: function (xhr) {
            //Add your image loader here

            },
            success: function (data) {
            location.reload();
            }
    });
    }
</script>
@endsection
