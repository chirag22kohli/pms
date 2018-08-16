<style>
    .error{
        color: red;
        font-size: 12px;
        padding: 18px;
    }
</style>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Project Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name = "project_type" class = "form-control" onchange = "changeType(this.value)">
            <option value ="public">Public</option>
            <option value ="restricted">Restricted</option>
            <option value ="paid">Paid</option>
        </select>
    </div>
</div>


<div id = "pricing" style = "display:none">
    <div  class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
        {!! Form::label('Price', 'Price', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('price', 0, ('required' == 'required') ? ['class' => 'price form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
        </div>


    </div>

    <div class="form-group {{ $errors->has('billing_cycle') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Billing Cycle', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            <select name = "billing_cycle" class = "b_cycle form-control">
                <option value ="weekly">Weekly</option>
                <option value ="monthly">Monthly</option>
                <option value ="yearly">Yearly</option>
            </select>
        </div>
    </div>

</div>

<div id = "restricted" style = "display:none">
    <p class="error">Note: You will need to add the UID list at the Project Listing Page for restricted Projects.</p>
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



    function changeType(type) {
        if (type == 'paid') {
            $('#pricing').show();
            $('.price').val('');
            $('#restricted').hide();
        } else if (type == 'restricted') {
            $('#pricing').hide();
            $('.price').val('0');
            $('#restricted').show();


        } else {
            $('#pricing').hide();
            $('.price').val('0');
            $('#restricted').hide();
        }
    }
</script>