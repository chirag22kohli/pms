@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New User Scan Pack</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/user-scan-packs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/admin/user-scan-packs', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('admin.user-scan-packs.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
