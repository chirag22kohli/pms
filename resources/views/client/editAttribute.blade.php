<form id = "attributeForm" name  = "attributeForm" method = "POST">
    @csrf
    <?php foreach ($getAttributes as $attribute) { ?>
        <input type="text" value = "<?= $attribute->attribute ?>" name = "attribute" class = "form-control"></br>
        <input type="hidden" value = "<?= $attribute->id ?>" name = "id" class = "form-control"></br>
    <?php }
    ?>

</form>

