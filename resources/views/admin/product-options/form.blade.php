<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    {!! Form::label('product_id', 'Product Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('product_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('attribute') ? 'has-error' : ''}}">
    {!! Form::label('attribute', 'Attribute', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('attribute', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('attribute', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('attribute_values') ? 'has-error' : ''}}">
    {!! Form::label('attribute_values', 'Attribute Values', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('attribute_values', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('attribute_values', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('user_id', 'User Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('user_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
