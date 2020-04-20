@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Tracker Support Tickets</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <thead>
                        <th>User Email</th>
                        <th>Project Name</th>
                        <th>Tracker Name</th>
                        <th>Tracker Image</th>
                        <th>Reason (Issue)</th>
                        <th>Date Time Created</th>
                        </thead>
                        <tbody>
                            <?php
                            if (count($trackerSupport) > 0) {
                                foreach ($trackerSupport as $support) {
                                    ?>
                                    <tr>
                                        <td><?= $support->email ?></td>
                                        <td><?= $support->projectName ?> </td>
                                        <td><?= $support->tracker_name ?></td>
                                        <td><img style ="width:30%" src = "{{{ isset($support->tracker_path) ? url($support->tracker_path) : url('images/No_Image_Available.png') }}}"></td>
                                        <td><?= $support->reason ?></td>
                                        <td><?= $support->created_at ?></td>
                                    </tr>
                                <?php }
                            } ?>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
