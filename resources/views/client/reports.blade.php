@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Reports</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <ul class="nav nav-tabs">

            <li class="nav-item active" ><a class="nav-link" id = "tabfirst" data-toggle="tab" href="#home">Projects Report</a></li>
            <li class="nav-item "><a class="nav-link"  data-toggle="tab" href="#myTransactions">My Transaction</a></li>
            <li class="nav-item "><a class="nav-link"  data-toggle="tab" href="#paidScanPacksHistory">Scan Pack Transactions</a> </li>
            <li class="nav-item "><a class="nav-link"  data-toggle="tab" href="#userScans">User Scans Report (Project Wise)</a> </li>

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
                    <h4 class="tittle-w3-agileits mb-4">My Transaction History</h4>
                    <div class="card-body card-padding">
                        <div class="">
                            <hr>
                            <div class="widget-body">
                                <div class="streamline">

                                    <?php
                                    if (count($myTransactions) > 0) {
                                        $i = 0;

                                        foreach ($myTransactions as $transaction) {
                                            $stripInfoPlan = json_decode($transaction->payment_params);
                                            if ($i % 2 == 0):
                                                $classname = 'border-primary';
                                            elseif ($i % 3 == 0):
                                                $classname = 'border-danger';
                                            else:
                                                $classname = 'border-info';
                                            endif;
                                            ?>
                                            <div class="sl-item border-left  <?= $classname ?>">
                                                <div class="sl-content">
                                                    <small class="text-muted">Plan : <?= $transaction['plan']->name ?></small> ||
                                                    <small class="text-muted">Transaction Date : <?= $transaction->created_at ?></small> ||
                                                    <small class="text-muted">Payment Type: <?= $transaction->payment_type ?></small>
                                                    <p>Amount Paid: $<?= $transaction->price_paid ?></p>

                                                    <p>Stripe Charge ID: <?= $stripInfoPlan->id ?> </p>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div id="paidScanPacksHistory" class="tab-pane fade in ">
                <div class="work-progres">
                    <h4 class="tittle-w3-agileits mb-4" style="margin-top:19px">Scan-Pack Spends </h4>

                    <div class="table-responsive">
                        <table id = "scanPacksTable" class="table mdl-data-table  table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Scan Credited</th>
                                    <th>Price Paid</th>
                                    <th>Stripe Transaction ID</th>
                                    <th>Payment Type</th>
                                    <th>Upgrade Month</th>
                                    <th>Date Charged</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($paidScanPacksHistory) > 0) {
                                    $i = 1;
                                    foreach ($paidScanPacksHistory as $info) {
                                        $stripInfo = json_decode($info->payment_params);
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $info->scans_credited ?></td>
                                            <td><span class="badge badge-pill badge-secondary">$<?= $stripInfo->amount / 100 ?></span></td>


                                            <td>
                                                <span class="badge badge-pill badge-primary"><?= $stripInfo->id ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?= $info['payment_type'] ?></span>
                                            </td>
                                            <td>{{ date("F", mktime(0, 0, 0, $info->month, 1)) }}</td>
                                            <td><?= $info->date_purchased ?> </td>
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
            <div id="userScans" class="tab-pane fade in ">
                <div class="work-progres">
                    <h4 class="tittle-w3-agileits mb-4" style="margin-top:19px">User Scans Report (Project Wise)</h4>

                    <div class="table-responsive">
                        <table id = "scanPacksTable" class="table mdl-data-table  table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>User Email</th>
                                    <th>Scans Used</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($getUserScan) > 0) {
                                    $i = 1;
                                    foreach ($getUserScan as $info) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $info->project_detail->name ?></td>
                                            <td><span class="badge badge-pill badge-secondary"><?= $info->project_user->email ?></span></td>
                                            <td><?= $info->count ?></td>
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


    <!--// Error Page Info -->

</div>

@endsection
