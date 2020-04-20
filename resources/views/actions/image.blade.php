<form  method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <p>Please choose image:</p></br>
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>
        </br>
        <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->

        </br>
        <?php
        if (isset($objectAction) && !empty($objectAction)) {
            echo '<img src = "'.$objectAction.'" style = "width: 90px">';
        }
        ?>
         </br>
        <p><b>Note:</b> Image is shown on the object when having the AR experience </p>

    </div>


</form>