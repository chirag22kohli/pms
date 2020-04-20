@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">ProductCategory {{ $productcategory->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/admin/product-categories') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/product-categories/' . $productcategory->id . '/edit') }}" title="Edit ProductCategory"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    {!! Form::open([
                    'method'=>'DELETE',
                    'url' => ['admin/productcategories', $productcategory->id],
                    'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-sm',
                    'title' => 'Delete ProductCategory',
                    'onclick'=>'return confirm("Confirm delete?")'
                    ))!!}
                    {!! Form::close() !!}
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th><td>{{ $productcategory->id }}</td>
                                </tr>
                                <tr><th> Name </th><td> {{ $productcategory->name }} </td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
