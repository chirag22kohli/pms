<div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
    
    <div class="col-md-6">
        {!! Form::hidden('project_id', $project_id, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('project_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('uid') ? 'has-error' : ''}}">
    {!! Form::label('uid', 'Uid', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('uid', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('uid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
