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
                <div class="card-header">Attributes - </div>
                <div class="card-body" style="padding:30px">
                    <?php
                    foreach ($productOptions as $option) {
                        $attributes = explode(',', $option->attribute_values);
                        ?>
                        <div class = "row">
                            <?= $option->attribute ?> &nbsp; <a  style = "color:blue" href = "#" onclick = "editAttribute({{ $option->id }})">Edit</a>
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
            var stockHtml = '<form name = "stockFrom" id = "stockFrom" enctype="multipart/form-data" action  = "'+url+'/admin/updateStock" method = "post">@csrf</br>In Stock - <input type = "number" class= "form-control" id = "stockValue" name= "stockValue" value= "' + data[0] + '"><input type = "hidden" id = "attributes" name = "attributes" value = "'+data[3]+'"></br>Price - (in SGD) $<input type = "number" step = "0.01" class= "form-control" id = "priceValue" name= "priceValue" value= "' + data[1] + '"></br><img style = "width:30%" src = "'+url+data[2]+'"> <input type = "hidden" value = "<?= $product->id ?>" name = "product_id" id = "product_id"></br> </br>Image - <input type = "file" name = "image"></br></br><a href  = "#" class="btn btn-xs btn-success"  onclick = "updateStock()">Update</a> </form>';
            $('.stock').html(stockHtml);
            }
    });
    }

    function updateStock(){
    
    var attributes = $("select[name='attributeValues'] :selected").map(function (i, el) {
    return $(el).val();
    }).get();
    //$('#attributes').val(attributes);
    $('#stockFrom').submit(); return false;
    var product_id = '<?= $product->id ?>';
    var stockValue = $('#stockValue').val();
     var price = $('#priceValue').val();
    var url = '<?= url('/') ?>';
    $.ajax({
    url: url + "/admin/updateStock",
            method: 'post',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#stockFrom').serialize()
    ,
            cache: false,
            success: function (data) {
            $.alert('Product Updated Successfully');
            }
    });
    }

    function editAttribute(productId){
    var url = '<?= url('client/editAttribute') ?>';
    var urlForm = '<?= url('client/attributeForm') ?>';
    $.confirm({
    theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Edit Attributes',
            content: 'url:' + url + '?id=' + productId,
            buttons: {
            formSubmit: {
            text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {



                    $.ajax({
                    url: urlForm,
                            method: 'post',
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: $('#attributeForm').serialize(),
                            cache: false,
                            success: function (data) {
                            location.reload();
                            }
                    });
                    }
            },
                    cancel: function () {
                    //close
                    },
            },
            onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
            }
    });
    }
</script>
@endsection
