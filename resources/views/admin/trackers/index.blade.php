@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

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
                                    <th>#</th><th>Tracker Name</th><th>Image</th><th>Height</th><th>Width</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trackers as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>

                                    <td>{{ $item->tracker_name }}</td>
                                    <td><img style ="width:30%" src = "{{{ isset($item->tracker_path) ? url($item->tracker_path) : url('images/No_Image_Available.png') }}}"><?php if (!isset($item->tracker_path)) { ?>
                                        <button onclick ="uploadTracker()" class = "btn btn-success trackerButton">Upload Tracker</button>

                                        <form  style ="display: none" enctype="multipart/form-data" name ="imageUploadForm" id =  "imageUploadForm" method = "post" action = "trackerUpload">
                                            <input type="file"  id ="trackerImage" name = "trackerImage" onchange="upload()">
                                            <input type ="hidden" name ="tracker_id" value = "{{$item->id}}">
                                        </form>

                                        <?php } ?>
                                    </td><td>745px</td><td>550px</td>
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

<script>
    function uploadTracker() {
        $('#trackerImage').click();
    }
    function upload() {
        //  $('#imageUploadForm').submit()
        $j("body").addClass("loading");
        var form = document.getElementById('imageUploadForm');
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
// Add any event handlers here...
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText);
                // console.log(obj);
                $j("body").removeClass("loading");
                if (obj.success == '1') {
                    location.reload();
                } else {
                    $.alert({
                        theme: 'supervan',
                        title: 'Uh Oh!',
                        content: 'This tracker is already used by any other project. Please select any other file.',
                    });
                }
            }
        };

        xhr.open('POST', 'trackerUpload', true);
        xhr.send(formData);

    }
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript">
    var $j = jQuery.noConflict(true);
</script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
@endsection
