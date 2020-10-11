@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Orders</div>
                <div class="card-body">


                    {!! Form::open(['method' => 'GET', 'url' => '/admin/orders', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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

                        <div id = "ajaxOrders"></div>




                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $.ajax({
        type: 'GET',
        url: "{{url('admin/getOrdersAjax')}}"

    }).done(function (data) {
        console.log('run');
        $('#ajaxOrders').html(data);
    });

    window.setInterval(function () {




        $.ajax({
            type: 'GET',
            url: "{{url('admin/getOrdersAjax')}}"

        }).done(function (data) {
            console.log('run');
            $('#ajaxOrders').html(data);
        });

    }, 2000);

</script>
@endsection
