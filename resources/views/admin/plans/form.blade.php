<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Plan Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name = "type" class = "form-control" onchange = "changeType(this.value)"> 
            <option value ="trackers_count">Limit by Trackers</option>
            <option value ="size">Limit by Size of Account </option>
           
        </select>
          {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('max_trackers') ? 'has-error' : ''}}">
    {!! Form::label('max_trackers', 'Max Trackers', ['class' => 'typeLable col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('max_trackers', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('max_trackers', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('max_projects') ? 'has-error' : ''}}">
   
    <div class="col-md-6">
        {!! Form::hidden('max_projects', 0, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('max_projects', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Price', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('price', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('price_type') ? 'has-error' : ''}}">
    {!! Form::label('price_type', 'Price Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name = "price_type" class = "form-control"> 
            <option value ="weekly">Weekly</option>
            <option value ="monthly">Monthly</option>
            <option value ="yearly">Yearly</option>
        </select>
          {!! $errors->first('price_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
   
    <div class="col-md-6">
        {!! Form::hidden('status', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
  
    <div class="col-md-6">
       
        {!! Form::hidden('created_by', Auth::user()->id, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script>
function changeType(type){
  if(type == 'trackers_count'){
      $('.typeLable').html('Max Trackers');
  }else if(type == 'size'){
      $('.typeLable').html('Max Size (In Megabytes)');
  }
}
</script>