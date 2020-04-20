<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('title', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('heptext') ? 'has-error' : ''}}">
    {!! Form::label('heptext', 'Heptext', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('heptext', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('heptext', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('params') ? 'has-error' : ''}}">
    {!! Form::label('params', 'Params', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('params', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('params', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
