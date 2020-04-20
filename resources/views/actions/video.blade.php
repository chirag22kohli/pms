<form  method="post" name="videoUpload" id="videoUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <p>Please choose an video file:(Acceptable formats: .mp4)</p></br>
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        <input type="file" name="videofile" id="videofile"  accept="video/mp4,video/x-m4v,video/*" required/>
        </br>
        <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->

        </br>
        <?php
        if (isset($objectAction->url) && !empty($objectAction->url)) {
            echo '<video width="240" height="180" controls>
  <source src="' . $objectAction->url . '" type="video/mp4">
  <source src="' . $objectAction->url . '" type="video/ogg">
Your browser does not support the video tag.
</video>';
        }
        ?>
        <p><b>Note:</b> Video file plays immediately when the tracker is detected, to play audio file after a button is tapped add a button and set the action to play an video file.</p>

    </div>


</form>