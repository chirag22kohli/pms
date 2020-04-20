<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('user_id', 'User Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('user_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('scan_pack_id') ? 'has-error' : ''}}">
    {!! Form::label('scan_pack_id', 'Scan Pack Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('scan_pack_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('scan_pack_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('scans') ? 'has-error' : ''}}">
    {!! Form::label('scans', 'Scans', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('scans', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('scans', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('scans_used') ? 'has-error' : ''}}">
    {!! Form::label('scans_used', 'Scans Used', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('scans_used', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('scans_used', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('limit_set') ? 'has-error' : ''}}">
    {!! Form::label('limit_set', 'Limit Set', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('limit_set', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('limit_set', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('used_limit') ? 'has-error' : ''}}">
    {!! Form::label('used_limit', 'Used Limit', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('used_limit', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('used_limit', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('total_scan_packs') ? 'has-error' : ''}}">
    {!! Form::label('total_scan_packs', 'Total Scan Packs', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('total_scan_packs', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('total_scan_packs', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('used_scan_packs') ? 'has-error' : ''}}">
    {!! Form::label('used_scan_packs', 'Used Scan Packs', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('used_scan_packs', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('used_scan_packs', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('user_plan_id') ? 'has-error' : ''}}">
    {!! Form::label('user_plan_id', 'User Plan Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('user_plan_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('user_plan_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
