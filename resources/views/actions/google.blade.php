<form  method="post" name="googleUpload" id="googleUpload" enctype="multipart/form-data">
    <input type="hidden" name="f_id" id="f_id" />		

    <div id="f_output" class="errMsg"></div>
    <div class="info padding_15"><div class="one_half_2">
            <div class="form-group  cls-file">
                <div class="Radio " style="width:100%;">
                    <label class="cls-file"  style="display:none">
                        <input type="radio" name="g_default" id="g_default" value ="default" <?php if (!isset($objectAction->trigger) || empty($objectAction->trigger) || $objectAction->trigger == 'default') {
    echo 'checked';
} ?>>
                        <span>Default Image</span>
                    </label>
                    <img src="" id="g_image" style="float:right;height:34px;" />
                </div>
            </div>
            <div class="one_half last">
                <img id="output7" style="max-width:100px; max-height:100;">
                <!--output id="image_preview_f" style="margin-right:15px;"></output-->

<!--li style="list-style:none;" id="image_preview_dummy_f"><img id="image_fb" src="img/noimage.png" style="width:25%;float:right;" /></li-->
            </div>
            <div class="form-group ">
                <div class="Radio cls-file" style="width:100%;">
                    <input style ="display:none;"  type = "file"   name ="get_social_google" id="get_social_google"  class="fileUpload" accept="image/*">
                    <label><input type="radio"  <?php if (isset($objectAction->trigger) && !empty($objectAction->trigger) && $objectAction->trigger == 'custom') {
    echo 'checked';
} ?>  value ="custom" name="g_default" id="g_custom" onclick="open_google_image()"><span>Custom Image</span></label>
                </div> 
            </div>
            <div class="form-group">
                <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
                <label for="Message" style="width:100%">Link to be shared </label>
                <input type="text"  value ="<?php if (isset($objectAction->message) && !empty($objectAction->message)) {
    echo $objectAction->message;
} ?>" id="google_msg" name="google_msg" class="form-control" required/>
            </div>
            <!--select name="buttoncheck" class="pmars-button">
                                    <option value="true">Show this button when image first dragged</option>
                                    <option value="false">Hide this button when image first dragged</option>
                    </select-->



        </div></div>
</form>	