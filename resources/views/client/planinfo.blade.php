@extends('layouts.client')

@section('content')
<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center" lang="en">Your Plan Info</h2>

<?php if (!$connectStatus) { ?>
    <p>Note: <i>To create Paid projects / Use Ecommerce and recieve payouts please connect your stripe account with Chap.</i></p></br>
    <a href ="https://dashboard.stripe.com/oauth/authorize?response_type=code&client_id={{ env('CONNECTED_CLIENT') }}&scope=read_write&redirect_uri={{ env('STRIPE_REDIRECT_URI') }}">
        <img src="{{ url('images/stripe.png')}}"></a> 
<?php } ?>

<div class="flash-message">
    </br>
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div> <!-- end .flash-message -->
<!--// main-heading -->

<!-- Error Page Content -->

<div class="blank-page-content">

    <!-- Error Page Info -->
    <section class="pricing-tables">
        <h4 class="tittle-w3-agileits mb-4 mt-3"></h4>
        <div class="card-deck text-center row">
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
                        <?php if ($planInfo->is_ecom == '1') { ?>
                         
   <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Includes Ecommerce</li> 

                        <?php } ?>
                        <?php if ($planInfo->type == 'size') { ?>
                            <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $planInfo->max_trackers }} MB Storage</li> 

                        <?php } else { ?>

                            <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>{{ $planInfo->max_trackers }} Trackers</li> 

                                <!--<li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Unlimited Storage</li> --> 

                        <?php } ?>
                        <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>True AR Experience</li>
                        <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>Reports</li>
                    </ul>
                    <button type="button" onclick ="location.href = 'upgradePlanView'" class="btn btn-lg btn-block btn-outline-primary py-2" data-toggle="modal" data-target="#exampleModal">Upgrade</button>
                </div>
            </div>

            <div class="outer-w3-agile mt-3  col-xl-8">
                <div class = "row">
                    <div class = "col-md-6">

                    </div>
                    <div class = "col-md-4">
                        <h4>Auto-renew</h4>
                    </div>
                    <div class = "col-md-2">
                        <label class="switch">
                            <input onchange = "manageReoccurring()" type="checkbox" <?php if ($userPlan->reoccuring_status) {
                            echo 'checked';
                        } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>


                <h4 class="tittle-w3-agileits mb-4" lang="en" data-lang-token="Dashboard"> Usage Stats and Expiry Information</h4>
                <table class="table table-bordered table-striped">
                    <thead>

                    </thead>
                    <tbody>
<?php if ($planInfo->type == 'size') { ?>
                            <tr>
                                <th class="text-nowrap"  lang="en" data-lang-token="Storage_thai" scope="row">Storage</th>

                                <td>{{ $planInfo->max_trackers }} MB Storage</td>
                            </tr>
<?php } else { ?>
                            <tr>
                                <th class="text-nowrap" scope="row">Total Trackers</th>
                                <td>
                                    {{ $planInfo->max_trackers }} Trackers
                                </td>

                            </tr>
                            <!-- <tr>
                                <th class="text-nowrap" scope="row">Storage</th>
                                <td>
                                    <code>Unlimited Storage</code>
                                </td>

                            </tr> -->
<?php } ?>
                        <tr>
                            <th class="text-nowrap" scope="row">Expiry Date</th>
                            <td>
<?= date('d/m/Y', strtotime($userPlan->plan_expiry_date)); ?> ({{ $difference }})
                            </td>

                        </tr>
<?php if ($planInfo->type == 'size') { ?>
                            <tr>
                                <th class="text-nowrap" scope="row">Usage</th>
                                <td colspan="5">{{ $usageInfo }}/ {{ $planInfo->max_trackers }} MiB</td>
                            </tr>
<?php } else { ?>
                            <tr>
                                <th class="text-nowrap" scope="row">Used Trackers</th>
                                <td colspan="5">{{ $trackerCount }}</td>
                            </tr>
<?php } ?>
                        <tr>
                            <th class="text-nowrap" scope="row"><input type="hidden" id ="csr" value="{{ csrf_token() }}"> </th>

                            <td colspan="5"><button type="button" onclick ="renewPlan('{{$planInfo->id}}')" class="btn btn-lg btn-block btn-outline-primary py-2" data-toggle="modal" data-target="#exampleModal">Renew Plan</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!--// Error Page Info -->

</div>


@endsection
