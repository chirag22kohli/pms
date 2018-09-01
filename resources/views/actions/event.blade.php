<form  method="post" name="eventUpload" id="eventUpload" enctype="multipart/form-data">
    <div class="form-group style_border">
        <input type="hidden" id = "object_id" name = "object_id" value = "<?php echo $object_id ?>">
        
        </br>
        <!--Loop <input type="checkbox" name="audio_loop" id ="audio_loop" value="true"></br>-->

        </br>
        <?php
        if (isset($objectImage) && !empty($objectImage)) {
            echo '<img src = "' . $objectImage . '" style = "width: 90px">';
        }
        ?>
        </br>
        <p><b>Note:</b> Image is shown on the object when having the AR experience </p>
       <?php if (isset($objectAction->message) && !empty($objectAction->message)) {
           $eventDetails = json_decode($objectAction->message);
          
        } ?>
       
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" value ="<?php if (isset($eventDetails->title) && !empty($eventDetails->title)) {
          echo $eventDetails->title;
        } ?>"  name = "title" class="form-control" id="title">
            </div>
            <div class="form-group">
                <label for="Location">Location</label>
                <input type="text"  value ="<?php if (isset($eventDetails->location) && !empty($eventDetails->location)) {
          echo $eventDetails->location;
        } ?>" name = "location" class="form-control" id="location">
            </div>
             <div class="form-group">
                <label for="pwd">Description </label>
                <textarea class = "form-group"  id = "description" name = "description" style ="height: 95px;
    width: 310px;"><?php if (isset($eventDetails->description) && !empty($eventDetails->description)) {
          echo $eventDetails->description;
        } ?></textarea>
            </div>
            <div class="form-group">
                <label for="pwd">Start Date</label>
                <input type="text" name = "start_date" value ="<?php if (isset($eventDetails->start_date) && !empty($eventDetails->start_date)) {
          echo $eventDetails->start_date;
        } ?>" class="form-control" id="start_date">
            </div>
            <div class="form-group">
                <label for="pwd">End Date</label>
                <input type="text" value ="<?php if (isset($eventDetails->end_date) && !empty($eventDetails->end_date)) {
          echo $eventDetails->end_date;
        } ?>" name = "end_date" class="form-control" id="end_date">
            </div>
            
        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>
        <p><b>Note:</b> Tap on event to add on device calendar.</p>

    </div>


</form>
<script>
  $( function() {
    $( "#start_date" ).datepicker();
    $( "#end_date" ).datepicker();
  } );
  </script>