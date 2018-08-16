@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body">
                    <a href="{{ url('/admin/projects/create') }}" class="btn btn-success btn-sm" title="Add New Project">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>

                    {!! Form::open(['method' => 'GET', 'url' => '/admin/projects', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}

                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>QR Code</th>
                                    <th>Project Details</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $item)

                                <?php
                                $var = ['id' => base64_encode($item->id), 'name' => base64_encode($item->name)];
                                $details = json_encode($var);
                                ?>
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td> {!! QrCode::encoding('UTF-8')->size(100)->generate($details); !!}</br><a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($details)) !!} " download>Download QR Code</a></td>
                                    <td>
                                        <?php if ($item->project_type != '') { ?>
                                        <b><p><?= ucfirst($item->project_type) ?></p></b>
                                        <?php }else{ ?>
                                            Not Found
                                        <?php } ?>
                                        <?php
                                        if ($item->project_type == 'restricted') { ?>
                                            <a class = "btn btn-sm btn-info" href = "{{ url('/admin/restricted-uid?p_id=' . $item->id) }}">View/Add UID</a>
                                       <?php } elseif ($item->project_type == 'paid') { ?>
                                            <b><p>Price: $<?= $item->price ?> </p></b>
                                             <b><p>Blling: <?= ucfirst($item->billing_cycle) ?></p></b>
                                        <?php } else {
                                            
                                        }
                                        ?>
                                    </td>
                                    <td>{{ $item->created_by }}</td>                                        
                                    <td>
                                        <a href="{{ url('/admin/trackers?p_id=' . $item->id) }}" title="View Trackers"><button class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Manage Trackers</button></a>
                                      <!--  <a href="{{ url('/admin/projects/' . $item->id) }}" title="View Project"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>-->
                                        <a href="{{ url('/admin/projects/' . $item->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                        {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/admin/projects', $item->id],
                                        'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-sm',
                                        'title' => 'Delete Project',
                                        'onclick'=>'return confirm("Confirm delete?")'
                                        )) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $projects->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
