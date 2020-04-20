@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Cron #{{ $cron->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/cron') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($cron, [
                            'method' => 'PATCH',
                            'url' => ['/admin/cron', $cron->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.cron.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
