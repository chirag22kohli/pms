@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">OrderDetail {{ $orderdetail->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/order-details') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/order-details/' . $orderdetail->id . '/edit') }}" title="Edit OrderDetail"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/orderdetails', $orderdetail->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete OrderDetail',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $orderdetail->id }}</td>
                                    </tr>
                                    <tr><th> Order Id </th><td> {{ $orderdetail->order_id }} </td></tr><tr><th> Product Id </th><td> {{ $orderdetail->product_id }} </td></tr><tr><th> Attributes </th><td> {{ $orderdetail->attributes }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
