<form  method="post" name="contactUpload" id="contactUpload" enctype="multipart/form-data">
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
        <?php
        if (isset($objectAction->message) && !empty($objectAction->message)) {
            $eventDetails = json_decode($objectAction->message);
        }
        ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" value =" <?php
            if (isset($eventDetails->namecontact) && !empty($eventDetails->namecontact)) {
                echo $eventDetails->namecontact;
            }
            ?>
                   "  name = "namecontact" class="form-control" id="namecontact">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="emailcontact"  value =" <?php
            if (isset($eventDetails->emailcontact) && !empty($eventDetails->emailcontact)) {
                echo $eventDetails->emailcontact;
            }
            ?>
                   " name = "emailcontact" class="form-control" id="emailcontact">
        </div>
        <div class="form-group">
            <label for="Number">Number</label>
            <input type="text"  value =" <?php
            if (isset($eventDetails->number) && !empty($eventDetails->number)) {
                echo $eventDetails->number;
            }
            ?>
                   " name = "number" class="form-control" id="number">
        </div>
        <div class="form-group">
            <label for="Address">Address </label>
            <textarea class = "form-group"  id = "address" name = "address" style ="height: 95px;
                      width: 310px;"> <?php
            if (isset($eventDetails->address) && !empty($eventDetails->address)) {
                echo $eventDetails->address;
            }
            ?>
            </textarea>
        </div>
        <div class="form-group">
            <label for="Company">Company</label>
            <input type="text" name = "company" value =" <?php
            if (isset($eventDetails->company) && !empty($eventDetails->company)) {
                echo $eventDetails->company;
            }
            ?>
                   " class="form-control" id="company">
        </div>
       

        <input type="file" name="imagefile" id="imagefile"  accept="image/*" required/>
        <p><b>Note:</b> Tap on contact to save on device.</p>

    </div>


</form>
<script>
    $(function () {
        $("#start_date").datepicker();
        $("#end_date").datepicker();
    });
</script>