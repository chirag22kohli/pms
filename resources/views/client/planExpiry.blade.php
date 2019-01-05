@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Current Plan Expired!</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">
    <div class="flash-message">
        </br>
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <p class="paragraph-agileits-w3layouts"><b>Your current plan has been expired. Please renew to continue the AR magic in your hands.</b>
        </p>
    </div>
    <div class="outer-w3-agile col-xl mt-3">
        <h4 class="tittle-w3-agileits mb-4">Renew Plan</h4>
        <section class="pricing-tables">
            <h4 class="tittle-w3-agileits mb-4 mt-3"></h4>
            <div class="card-deck text-center row">
                <div class="card box-shadow col-xl-4 col-md-4">
                    <div class="card-header">
                        <input type="hidden" id ="csr" value="{{ csrf_token() }}"> 
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
                        
                        <button type="button" onclick ="renewExpiredPlan('{{$planInfo->id}}')" class="btn btn-lg btn-block btn-outline-primary py-2" data-toggle="modal" data-target="#exampleModal">Renew Plan</button>
                    </div>
                </div>
                <div style ="text-align: left" class = "  col-xl-8 col-md-8">
                    <p></p>
                    <p class="paragraph-agileits-w3layouts"><b>Note: Your current plan has been expired. Please renew to continue the AR magic in your hands. Please keep the reoccurrence toggle on in your plan information page to enjoy hassal free AR experience in your hands. </b>
                </div>


            </div>

        </section>
    </div>
    <!--// Error Page Info -->

</div>
@endsection
