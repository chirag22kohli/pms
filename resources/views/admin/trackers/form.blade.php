<div class="form-group {{ $errors->has('tracker_name') ? 'has-error' : ''}}">
    {!! Form::label('tracker_name', 'Tracker Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tracker_name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('tracker_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
    {!! Form::label('project_id', 'Project Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('project_id', $project_id, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','readonly' => 'true'] : ['class' => 'form-control']) !!}
        {!! $errors->first('project_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
