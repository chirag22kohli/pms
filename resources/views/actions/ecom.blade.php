<form  method="post" name="ecomUpload" id="ecomUpload" enctype="multipart/form-data">
    <div class="form-group style_border">

  <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->
        </br>
        <p style = "text-align:left"><b>Choose Custom Image:</b></p>
        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">

        </br>
        </br>
        <?php
        if (isset($objectImage) && !empty($objectImage)) {
            echo '<img src = "' . $objectImage . '" style = "width: 90px">';
        }
        ?>
        </br>
        </br>
        </br>

        <select name = "product" id = "product">
            <?php foreach ($products as $product) { ?>
                <option  <?php
                if (isset($objectAction->message) && !empty($objectAction->message) && $objectAction->message == $product->id ) {
                    echo 'selected';
                }
                ?> value = "<?= $product->id ?>" ><?= $product->name ?> </option>
<?php }
?>

        </select>

        <p><b>Note:</b> Product Detail will be opened on the App once the user click on the Ecommerce Product.</p>

    </div>


</form>