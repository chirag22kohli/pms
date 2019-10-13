@extends(\Auth::user()->roles[0]->name == 'Client' ? 'layouts.client' : 'layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @if(Auth::user()->roles[0]->name == 'Admin')
        @include('admin.sidebar')
        @endif

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Product #{{ $product->id }}</div>
                <div class="card-body">
                    <a href="{{ url('/admin/products') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! Form::model($product, [
                    'method' => 'PATCH',
                    'url' => ['/admin/products', $product->id],
                    'class' => 'form-horizontal',
                    'files' => true
                    ]) !!}

                    @include ('admin.products.form', ['submitButtonText' => 'Update'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        <div class = "col-md-4">
            <div class="card">
                <div class="card-header">Attributes</div>
                <div class="card-body" style="padding:30px">
                    <?php
                    foreach ($productOptions as $option) {
                        $attributes = explode(',', $option->attribute_values);
                        ?>
                        <div class = "row">
                            <?= $option->attribute ?> 
                            <select class="form-control" onchange ="$('.stock').html(' ')" name = "attributeValues">
                                <?php foreach ($attributes as $attribute) { ?>
                                    <option><?= $attribute ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    <?php } ?>


                    <div class = "stock">


                    </div>
                </div>
                <a href = "#" class = "btn btn-xs btn-success" style="color:#fff" onclick = "getAttributes()">Get Stock Value</a>
            </div>
        </div>
    </div>
</div>
<script>

    function getAttributes() {
        $('.stock').html(' ');
        var attributes = $("select[name='attributeValues'] :selected").map(function (i, el) {
            return $(el).val();
        }).get();
        var product_id = '<?= $product->id ?>';
        var url = '<?= url('/') ?>';
        $.ajax({
            url: url + "/admin/getProductAttributeStock",
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {attributes: attributes, product_id: product_id}
            ,
            cache: false,

            success: function (data) {
                var stockHtml = '</br>In Stock - <input type = "number" class= "form-control" id = "stockValue" name= "stock" value= "' + data + '"></br> <a href = "#" onclick = "updateStock()" class="btn btn-xs btn-success">Update</a>';
                $('.stock').html(stockHtml);
            }
        });
    }
    
    function updateStock(){
     var attributes = $("select[name='attributeValues'] :selected").map(function (i, el) {
            return $(el).val();
        }).get();
        var product_id = '<?= $product->id ?>';
        
        var stockValue = $('#stockValue').val();
        
        
        var url = '<?= url('/') ?>';
        $.ajax({
            url: url + "/admin/updateStock",
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {attributes: attributes, product_id: product_id, stockValue:stockValue}
            ,
            cache: false,

            success: function (data) {
                $.alert('Stock Updated Successfully');
            }
        });
    }
</script>
@endsection
