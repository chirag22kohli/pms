@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Scan Packs Usage/Limit</h2>
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

    <div class="outer-w3-agile col-xl mt-3">
        <div class="row">
            <div class = "col-md-3">
                <ul class="list-unstyled mt-3 mb-4">
                    <?php
                    if ($getScanPack->scans_used == null) {
                        $getScanPack->scans_used = 0;
                    }
                    ?>

                    <li class="py-2 border-bottom">Scan Pack Price <b>$<?= $scanPackDetails->price ?></b></li> 
                    <li class="py-2 border-bottom">Scans Per Pack <b><?= $scanPackDetails->scans ?></b></li> 


                    <li class="py-2 border-bottom">Used Scans: <b><?= $getScanPack->scans_used ?></b></li> 

                    <li class="py-2 border-bottom">Total Left Over Scans: <b><?= $getScanPack->scans ?></b></li> 
                    <?php if ($getScanPack->total_scan_packs != null && $getScanPack->total_scan_packs != "") { ?>

                        <?php if ($getScanPack->used_scan_packs != null && $getScanPack->used_scan_packs != "") { ?>
                            <li class="py-2 border-bottom">Total Scan Packs Left: <b><?= $getScanPack->total_scan_packs - $getScanPack->used_scan_packs ?></b></li> 

                        <?php } else { ?>
                            <li class="py-2 border-bottom">Total Scan Packs Left: <b><?= $getScanPack->total_scan_packs ?></b></li> 

                        <?php } ?>

                    <?php } ?>

                    <?php if ($getScanPack->used_scan_packs != null && $getScanPack->used_scan_packs != "") { ?>
                        <li class="py-2 border-bottom">Total Used Scan Packs(According to Limit) : <b><?= $getScanPack->used_scan_packs ?></b></li> 

                    <?php } else { ?>
                        <li class="py-2 border-bottom">Total Used Scan Packs(According to Limit) : <b>N/A</b></li> 
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-12">
                <h4 class="tittle-w3-agileits mb-4">Set Limit </h4>
                <form action="setTrackerLimit" method="post">
                    {!! Form::token() !!}


                    <div class="form-group">
                        <label for="issue">Please set your Limit for Scan Packs: </label>
                        <div class = "row">
                            <div class = "col-md-1" style="padding-right: 0px;    margin-left: -60px;">
                                <p style="float: right;font-size: 26px">$</p>
                            </div>
                            <div class = "col-md-8" style="padding-left: 0px">
                                <input style ="width:50%" type="number" name ="limit" value = "<?= $getScanPack->limit_set ?>" class="form-control" id="exampleFormControlInput1" placeholder="<?= $getScanPack->limit_set ?>" required="" > 
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <p class="paragraph-agileits-w3layouts"><b>Note: This is the maximum monthly spend on scan packs.  Once the current scan pack finishes, a new one will be purchased automatically till this limit is reached. </b>
            </div>
        </div>
    </div>


</div>
@endsection
