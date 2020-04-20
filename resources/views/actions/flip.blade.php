<form  method="post" name="flipUpload" id="flipUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <p>Please choose image:</p></br>
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>
        </br>
        <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->

        </br>
        <?php
        if (isset($objectImage) && !empty($objectImage)) {
            echo '<img src = "'.$objectImage.'" style = "width: 90px">';
        }
        ?>
         </br>
        <p><b>Note:</b> Clicking on the object will reverse (flip) the AR camera. </p>

    </div>


</form>