@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Trackers</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/trackers/create?p_id='.$project_id) }}" class="btn btn-success btn-sm" title="Add New Tracker">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/admin/trackers', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                                        <th>#</th><th>Tracker Name</th><th>Height</th><th>Width</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($trackers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->tracker_name }}</td><td>{{ $item->height }}</td><td>{{ $item->width }}</td>
                                        <td>
                                             <a href="{{ url('/admin/arDashboard?id=' . $item->id) }}" title="Manage AR"><button class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Manage AR</button></a>
                                            <!--<a href="{{ url('/admin/trackers/' . $item->id) }}" title="View Tracker"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/trackers/' . $item->id . '/edit') }}" title="Edit Tracker"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>-->
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/trackers', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Tracker',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                                
                                               
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $trackers->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
