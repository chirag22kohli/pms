@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')
@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" accept=".xlsx" required>

                                    @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name = "project_id" value = "<?= $project_id; ?>">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label style = "color:#8BC34A">
                                            Note: File should contain header row. Please download the sample to create a xlsx file into the same format.</br></br></br> <a href ="{{ url('restrictedCsv/sample.xlsx') }}" download>Download Sample.</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Parse CSV
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection