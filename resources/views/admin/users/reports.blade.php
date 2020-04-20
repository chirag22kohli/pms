@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body"> <div class="outer-w3-agile mt-3">
                        <ul class="nav nav-tabs">

                            <li class="nav-item active"><a class="nav-link" id = "tabfirst" data-toggle="tab" href="#home">Projects Income Reports</a></li>
                            <li class="nav-item "><a class="nav-link"  data-toggle="tab" href="#myTransactions">Plan Transactions</a></li>

                        </ul>
                        <div class="tab-content">


                            <div id="home" class="tab-pane fade in active show">

                                <div class="work-progres">
                                    <h4 class="tittle-w3-agileits mb-4" style="margin-top:19px">Paid Projects Earnings</h4>
                                    <div class="widget-header row justify-content-between mb-3">
                                        <div class="col">

                                        </div>
                                        <div class="col">
                                            <h3 class="text-right">Total Earned: $<?= $totalPaid ?></h3>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id = "paidProjects" class="table mdl-data-table  table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Price Paid</th>

                                                    <th>User Email (Payee User)</th>
                                                    <th>Stripe Transaction ID</th>
                                                    <th>Date Chatged</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (count($paidInfo) > 0) {
                                                    $i = 1;
                                                    foreach ($paidInfo as $info) {
                                                        $stripInfo = json_decode($info->payment_params);
                                                        ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= $info['projectDetail']->name ?></td>
                                                            <td><span class="badge badge-pill badge-secondary">$<?= $stripInfo->amount / 100 ?></span></td>

                                                            <td>
                                                                <span class="badge badge-info"><?= $info['userDetail']->email ?></span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-pill badge-primary"><?= $stripInfo->id ?></span>
                                                            </td>
                                                            <td><?= $info->created_at ?></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!--<div id="tab1" class="tab-pane fade">
                                <h3>Tab1 Content</h3>
                                <p>Don't Forget</p>
                            </div>-->
                            <div id="myTransactions" class="tab-pane fade in ">
                                <div class="outer-w3-agile col-xl mt-3">
                                    <h4 class="tittle-w3-agileits mb-4">Plans Transaction History</h4>
                                    <div class="card-body card-padding">
                                        <div class="">
                                            <hr>
                                            <div class="table-responsive">
                                                <table id = "paidProjects" class="table mdl-data-table  table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Plan Name</th>
                                                            <th>Transaction Date</th>

                                                            <th>Payment Type</th>
                                                            <th>Amount Paid</th>
                                                            <th>Stripe Charge ID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (count($myTransactions) > 0) {
                                                            $i = 1;
                                                            foreach ($myTransactions as $transaction) {
                                                                $stripInfoPlan = json_decode($transaction->payment_params);
                                                                ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $transaction['plan']->name ?></td>
                                                                    <td><span class="badge badge-pill badge-secondary"> <?= $transaction->created_at ?></span></td>

                                                                    <td>
                                                                        <span class="badge badge-info"> <?= $transaction->payment_type ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-pill badge-primary">$<?= $transaction->price_paid ?></span>
                                                                    </td>
                                                                    <td> <?= $stripInfoPlan->id ?></td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?> 
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
            </div>
        </div>
    </div>
</div>
<script>
$('#tabfirst').click();
</script>
@endsection
