<form  method="post" name="tapAudioUpload" id="tapAudioUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <p>Please choose an audio file:(Acceptable formats: .mp3, .wav)</p></br>
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        <input type="file" name="audiofile" id="audiofile"  accept="audio/*" required/>
        </br>
        <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->

        </br>
        <p style = "text-align:left"><b>Choose Custom Image:</b></p>
        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>

        </br>
        
        <?php
        if (isset($objectImage) && !empty($objectImage)) {
            echo '<img src = "'.$objectImage.'" style = "width: 90px">';
        }
        ?>
        </br>
        </br>
        <?php
        if (isset($objectAction->url) && !empty($objectAction->url)) {
            echo '<audio controls>
  <source src="' . $objectAction->url . '" type="audio/ogg">
  <source src="' . $objectAction->url . '" type="audio/mpeg">
Your browser does not support the audio element.
</audio>';
        }
        ?>
        <p><b>Note:</b>  Audio file plays when you tap on this object while have AR experience.</p>

    </div>


</form>