<form  method="post" name="webLinkUpload" id="webLinkUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
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
        <p><b>Note:</b> Image is shown on the object when having the AR experience </p>
        <input type="text" value="<?php  if (isset($objectAction->message) && !empty($objectAction->message)) { echo $objectAction->message; }?>" placeholder = "Please enter web link" name = "webLink" id = "webLink" class="form-control" required>
        <p><b>Note:</b> Tap on Web Link to open link on device.</p>

    </div>


</form>