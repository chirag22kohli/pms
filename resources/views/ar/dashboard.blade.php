@extends('layouts.ar')

@section('content')
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        //Counter
        counter = <?php echo $cloneId; ?>;

        //Make element draggable
        $j(".drag").draggable({
            revert: 'invalid',
            helper: 'clone',
            containment: 'frame',
            //When first dragged
            stop: function (ev, ui) {
                var pos = $j(ui.helper).offset();
                objName = "#clonediv" + counter;
                objNameDB = "clonediv" + counter;
                $(objName).css({"left": pos.left, "top": pos.top});
                $(objName).removeClass("drag");
                //When an existiung object is dragged
                $j(objName).draggable({
                    containment: 'parent',
                    stop: function (ev, ui) {
                        var pos = $(ui.helper).offset();
                        var left_tracker = pos.left - $("#frame").position().left;
                        var top_tracker = pos.top - $("#frame").position().top;
                        addObject(objNameDB, pos.left, pos.top, left_tracker, top_tracker);


                    }
                });
            }
        });
        //Make element droppable
        $j("#frame").droppable({
            revert: false,
            drop: function (ev, ui) {
                if (ui.helper.attr('id').search(/drag[0-9]/) != -1) {
                    counter++;

                    var element = $(ui.draggable).clone();
                    element.addClass("tempclass");
                    $(this).append(element);
                    $(".tempclass").attr("id", "clonediv" + counter);
                    $("#clonediv" + counter).removeClass("tempclass");
                    //Get the dynamically item id
                    draggedId = ui.helper.attr('id').match(/\d+$/);
                    //  console.log(draggedId);
                    draggedNumber = ui.helper.attr('id').search(/drag([0-9])/)
                    itemDragged = "dragCommon dragged" + draggedId

                    $j("#clonediv" + counter).css('position', 'absolute');
//                    $j("#clonediv" + counter).resizable({aspectRatio: true,
//                        resize: function (event, ui) {
//                            var left_tracker = pos.left - $("#frame").position().left;
//                            var top_tracker = pos.top - $("#frame").position().top;
//                            addObject("clonediv" + counter, pos.left, pos.top, left_tracker, top_tracker);
//                        }
//                        stop: function(e, ui) {
//                            
//                        }
//                    });
                    $j("#clonediv" + counter).addClass(itemDragged);
                    var pos = $(ui.helper).offset();
                    var left_tracker = pos.left - $("#frame").position().left;
                    var top_tracker = pos.top - $("#frame").position().top;
                    addObject("clonediv" + counter, pos.left, pos.top, left_tracker, top_tracker);

                    initActions();
                    $("#clonediv" + counter).dblclick();
                }
            }
        });
        commonInitiate();
        initActions();
    });

    function commonInitiate() {

        $j.each($('.dragCommon'), function () {

            $j('#' + this.id).draggable({
                containment: 'parent',
                stop: function (ev, ui) {
                    var pos = $(ui.helper).offset();
                    var left_tracker = pos.left - $("#frame").position().left;
                    var top_tracker = pos.top - $("#frame").position().top;
                   
                    addObject(this.id, pos.left, pos.top, left_tracker, top_tracker);
//                    $j('#' + this.id).resizable({aspectRatio: true,
//                        ghost: true,
//                        resize: function (event, ui) {
//                            var left_tracker = pos.left - $("#frame").position().left;
//                            var top_tracker = pos.top - $("#frame").position().top;
//                            addObject(this.id, pos.left, pos.top, left_tracker, top_tracker);
//                        }
//                    });
                }
            });



        });

    }
    function uploadTracker() {
        $('#trackerImage').click();
    }

    function upload() {
        //  $('#imageUploadForm').submit()

        $j("body").addClass("loading");
        var form = document.getElementById('imageUploadForm');
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
// Add any event handlers here...
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText);
                // console.log(obj);
                $j("body").removeClass("loading");
                if (obj.success == '1') {
                    alert('ss');
                    $j('#frame').css("background-image", "url(" + obj.path + ")");
                } else {
                    $.alert({
                        theme: 'supervan',
                        title: 'Uh Oh!',
                        content: 'This tracker is already used by any other project. Please select any other file.',
                    });
                }
            }
        };

        xhr.open('POST', 'trackerUpload', true);
        xhr.send(formData);

    }

    function addObject(objName, xpos, ypos, left_tracker, top_tracker) {

        var left_tracker_new =  left_tracker - 268;
        left_tracker = left_tracker_new;
        console.log(left_tracker);
        var type = $('#' + objName).attr('type');
        var width = $('#' + objName).css('width');
        var height = $('#' + objName).css('height');
        var main_class = $('#' + objName).attr('main_class');

        var tracker_id = '<?php echo $tracker_id ?>';
        // console.log(tracker_id);
        var bg = $('#' + objName).css('background-image');
        bg = bg.replace('url(', '').replace(')', '').replace(/\"/gi, "");
        //console.log(bg);
        $.ajax({
            type: "POST",
            url: 'addUpdateObject',
            data: {type: type, width: width, height: height, xpos: xpos, ypos: ypos, main_class: main_class, tracker_id: tracker_id, object_div: objName, pos_top: top_tracker, pos_left: left_tracker, object_image: bg},

            success: function (msg) {
                console.log(msg);
            }
        });

    }
    function finalizeTracker() {
        var tracker_id = '<?php echo $tracker_id ?>';

        // return false;
        $.ajax({
            type: "POST",
            url: 'finalizeTracker',
            data: {tracker_id: tracker_id},
            beforeSend: function () {
                $("body").addClass("loading");
            },
            success: function (msg) {
                console.log(msg);
                $("body").removeClass("loading");
            }
        });
    }

 $.alert({
                        theme: 'supervan',
                        title: 'Note',
                        content: 'Click on Finalize Tracker before navigating away from this page. Changes may not be saved otherwise.',
                    });
</script>
<script src="{{ asset('js/ar/ar.js') }}"></script>
<div class="modal"><!-- Place at bottom of page --></div>

<div>
    <div id="wrapper">
        <div class = "row">
            <div class = "col-md-9">
                <button class = "btn btn-link finalizeButton"  onclick="finalizeTracker()" >Finalize Tracker</button>
            </div>
            <!--<div class = "col-md-3"> <button onclick ="uploadTracker()" class = "btn btn-success trackerButton">Upload Tracker</button></div>
            <form  style ="display: none" enctype="multipart/form-data" name ="imageUploadForm" id =  "imageUploadForm" method = "post" action = "trackerUpload">
                <input type="file"  id ="trackerImage" name = "trackerImage" onchange="upload()">
                <input type ="hidden" name ="tracker_id" value = "{{$tracker_id}}">
            </form>-->

        </div>
        </br>
      
        <div id="options">
            <div class="card-header optionHeader"><h4>Objects</h4></div>
            <div id="drag1" main_class ="dragged1" type ="google" class="drag dragCommon" title="Google Plus"></div> <!-- end of drag1 -->
            <div id="drag2" main_class ="dragged2" type ="facebook" class="drag dragCommon" title="Facebook"></div> <!-- end of drag2 -->
            <div id="drag3" main_class ="dragged3" type ="audio" class="drag dragCommon"  title="Auto-play Audio"></div> <!-- end of drag3 -->
            <div id="drag4" main_class ="dragged4" type ="video" class="drag dragCommon" title="Auto-play Video"></div> <!-- end of drag4 -->
            <div id="drag5" main_class ="dragged5" type ="image" class="drag dragCommon" title="Image"></div> <!-- end of drag5 -->
            <div id="drag6" main_class ="dragged6" type ="email" class="drag dragCommon" title="Email"></div> <!-- end of drag6 -->
            <div id="drag7" main_class ="dragged7" type ="web_link" class="drag dragCommon" title="Web Link"></div> <!-- end of drag6 -->
            <div id="drag8" main_class ="dragged8" type ="event" class="drag dragCommon" title="Calender"></div> <!-- end of drag6 -->
            <div id="drag9" main_class ="dragged9" type ="contact" class="drag dragCommon" title="Contact"></div> <!-- end of drag6 -->
            <div id="drag10" main_class ="dragged10" type ="youtube" class="drag dragCommon" title="Youtube"></div> <!-- end of drag6 -->
            <div id="drag11" main_class ="dragged11" type ="flip" class="drag dragCommon" title="Switch Camera"></div> <!-- end of drag6 -->
            <div id="drag12" main_class ="dragged12" type ="screenshot" class="drag dragCommon" title="Screen Shot" ></div> <!-- end of drag6 -->
            <div id="drag13" main_class ="dragged13" type ="tapaudio" class="drag dragCommon" title="Tap to play audio"></div> <!-- end of drag6 -->
            <div id="drag14" main_class ="dragged14" type ="tapvideo" class="drag dragCommon" title="Tap to play video"></div> <!-- end of drag6 -->

        </div><!-- end of options -->
        <div class="card-header frameHeader"><h4>Frame</h4></div>
        <div id="frame" <?php if (!empty($tracker)) { ?> style="background-image: url(<?php echo url($tracker); ?>); background-size: contain;width:<?= $trackerDetails->width ?>px;height:<?= $trackerDetails->height ?>px" <?php } ?>>
            
            <?php
            if (count($objects) > 0) {
                foreach ($objects as $object) {
                    ?>
                    <div id="<?php echo $object->object_div ?>" main_class="<?php echo $object->main_class ?>" type="<?php echo $object->type ?>" class="dragCommon ui-draggable  <?php echo $object->main_class ?>" style="position: absolute;background-size: cover; left: <?php echo $object->xpos ?>px ; top: <?php echo $object->ypos ?>px; height:  <?php echo $object->height ?>; width:  <?php echo $object->width ?>; background-image: url(<?php echo $object->object_image ?>)"></div>
                    <?php
                }
            }
            ?>
        </div><!-- end of frame -->

    </div>

</div>
<script type="text/javascript">
    $(window).on('beforeunload', function () {
        return "Good Bye";
    });
</script>
@endsection
