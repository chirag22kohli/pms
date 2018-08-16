@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif


            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">RestrictedUid {{ $restricteduid->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/restricted-uid?p_id='.$restricteduid->project_id ) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                       {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/restricteduid', $restricteduid->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete RestrictedUid',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $restricteduid->id }}</td>
                                    </tr>
                                    <tr><th> Project Id </th><td> {{ $restricteduid->project_id }} </td></tr><tr><th> Uid </th><td> {{ $restricteduid->uid }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
