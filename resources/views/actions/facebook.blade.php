<form  method="post" name="facebookUpload" id="facebookUpload" enctype="multipart/form-data">
    <input type="hidden" name="f_id" id="f_id" />		

    <div id="f_output" class="errMsg"></div>
    <div class="info padding_15"><div class="one_half_2">
            <div class="form-group  cls-file">
                <input type = "file"   name ="get_social_facebook" id="get_social_google"  class="fileUpload" accept="image/*">
            </div>
            <div class="one_half last">
                <img id="output7" style="max-width:100px; max-height:100;">
                <!--output id="image_preview_f" style="margin-right:15px;"></output-->

<!--li style="list-style:none;" id="image_preview_dummy_f"><img id="image_fb" src="img/noimage.png" style="width:25%;float:right;" /></li-->
            </div>
            <?php
            if (isset($objectImage) && !empty($objectImage)) {
                echo '<img src = "' . $objectImage . '" style = "width: 90px">';
            }
            ?>
            </br>

            <div class="form-group">
                <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
                <label for="Message" style="width:100%">Link to be shared</label>
                <input type="text"  value ="<?php
                if (isset($objectAction->message) && !empty($objectAction->message)) {
                    echo $objectAction->message;
                }
                ?>" id="facebook_msg" name="facebook_msg" class="form-control" required/>
            </div>
            <!--select name="buttoncheck" class="pmars-button">
                                    <option value="true">Show this button when image first dragged</option>
                                    <option value="false">Hide this button when image first dragged</option>
                    </select-->



        </div></div>
</form>	