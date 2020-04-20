@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif


        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Restricteduid</div>
                <div class="card-body">
                    <a href="{{ url('/admin/restricted-uid/create?p_id='.$project_id) }}" class="btn btn-success btn-sm" title="Add New RestrictedUid">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>
                    <a href="{{ url('/admin/import?p_id='.$project_id) }}" class="btn btn-success btn-sm" title="Import RestrictedUid">
                        Import CSV
                    </a>
                    <button type="submit" class="delete btn btn-danger btn-sm" onclick ="deleteMultiple()" disabled="disabled">Delete</button>
                    {!! Form::open(['method' => 'GET', 'url' => '/admin/restricted-uid', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                        <input type="hidden" id ="csr" value="{{ csrf_token() }}">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th></th>  <th>#</th><th>Project Id</th><th>Uid</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restricteduid as $item)
                                <tr>
                                    <td><input class="checkbox" name ="id[]" value="{{$item->id}}" type="checkbox"></td>

                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>{{ $item->project_id }}</td><td>{{ $item->uid }}</td>
                                    <td>
                                        <a href="{{ url('/admin/restricted-uid/' . $item->id) }}" title="View RestrictedUid"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/admin/restricted-uid', $item->id],
                                        'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-sm',
                                        'title' => 'Delete RestrictedUid',
                                        'onclick'=>'return confirm("Confirm delete?")'
                                        )) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $restricteduid->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".checkbox").click(function () {
            $('.delete').prop('disabled', $('input.checkbox:checked').length == 0);
        });
    });
    function deleteMultiple() {
        $.confirm({
            title: 'Delete UID?',
            content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
            autoClose: 'cancel|8000',
            buttons: {
                deleteUser: {
                    text: 'delete',
                    action: function () {
                        var arr = [];
                        $(".checkbox:checked").each(function () {
                            arr.push($(this).val());
                        });
                        $.ajax({
                            url: "deleteMultipleUid",
                            method: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('#csr').val()
                            },
                            data: {uid: arr},
                            cache: false,
                          
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }
                },
                cancel: function () {
                    text: 'Cancel'
                    // $.alert('action is canceled');
                }
            }
        });
    }


</script>
@endsection
