@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Your Plan Info</h2>
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

                        <?php if ($planInfo->type == 'size') { ?>
                            <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $planInfo->max_trackers }} MB Storage</li> 

                        <?php } else { ?>

                            <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>{{ $planInfo->max_trackers }} Trackers</li> 

                            <li class="py-2 border-bottom"><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Unlimited Storage</li> 

                        <?php } ?>
                        <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>True AR Experience</li>
                        <li class="py-2 border-bottom"><i class="fa fa-check" aria-hidden="true"></i>Reports</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-outline-primary py-2" data-toggle="modal" data-target="#exampleModal">Upgrade</button>
                </div>
            </div>
            <div class="outer-w3-agile mt-3  col-xl-8">
                <h4 class="tittle-w3-agileits mb-4">Usage Stats and Expiry Information</h4>
                <table class="table table-bordered table-striped">
                    <thead>

                    </thead>
                    <tbody>
                        <?php if ($planInfo->type == 'size') { ?>
                            <tr>
                                <th class="text-nowrap" scope="row">Storage</th>

                                <td>{{ $planInfo->max_trackers }} MB Storage</td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th class="text-nowrap" scope="row">Total Trackers</th>
                                <td>
                                    <code>{{ $planInfo->max_trackers }} Trackers</code>
                                </td>
                                
                            </tr>
                            <tr>
                                <th class="text-nowrap" scope="row">Storage</th>
                                <td>
                                    <code>Unlimited Storage</code>
                                </td>
                                
                            </tr>
                        <?php } ?>
                        <tr>
                            <th class="text-nowrap" scope="row">Expiry Date</th>
                            <td>
                                <code>{{ $userPlan->plan_expiry_date }} ({{ $difference }})</code>
                            </td>
                           
                        </tr>
                        <tr>
                            <th class="text-nowrap" scope="row">Usage</th>
                            <td colspan="5">{{ $usageInfo }}/∞</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap" scope="row">Used Trackers</th>
                            <td colspan="5">{{ $trackerCount }}</td>
                        </tr>
                       
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
