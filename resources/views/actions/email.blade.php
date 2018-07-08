<form  method="post" name="emailUpload" id="emailUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        <input type="text" value="<?php  if (isset($objectAction->message) && !empty($objectAction->message)) { echo $objectAction->message; }?>" placeholder = "Please enter email" name = "email" id = "email" class="form-control" required>
        <p><b>Note:</b> Tap on Email to send email on device.</p>

    </div>


</form>