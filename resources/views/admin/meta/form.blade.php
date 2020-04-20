<div class="form-group {{ $errors->has('meta_name') ? 'has-error' : ''}}">
    {!! Form::label('meta_name', 'Meta Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('meta_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('meta_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
    {!! Form::label('meta_description', 'Meta Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('meta_description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
