@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit RestrictedUid #{{ $restricteduid->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/restricted-uid') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($restricteduid, [
                            'method' => 'PATCH',
                            'url' => ['/admin/restricted-uid', $restricteduid->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.restricted-uid.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
