@extends('layouts.ar')

@section('content')
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        //Counter
        counter = <?php echo $cloneId; ?>;
        //Make element draggable
        $(".drag").draggable({
            helper: 'clone',
            containment: 'frame',
            //When first dragged
            stop: function (ev, ui) {
                var pos = $(ui.helper).offset();
                objName = "#clonediv" + counter;
                objNameDB = "clonediv" + counter;
                $(objName).css({"left": pos.left, "top": pos.top});
                $(objName).removeClass("drag");
                //When an existiung object is dragged
                $(objName).draggable({
                    containment: 'parent',
                    stop: function (ev, ui) {
                        var pos = $(ui.helper).offset();
                        addObject(objNameDB, pos.left, pos.top);
                    }
                });
            }
        });
        //Make element droppable
        $("#frame").droppable({
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
                    draggedNumber = ui.helper.attr('id').search(/drag([0-9])/)
                    itemDragged = "dragCommon dragged" + RegExp.$1

                    $("#clonediv" + counter).css('position', 'absolute');
                    $("#clonediv" + counter).resizable({aspectRatio: true,
                        resize: function (event, ui) {
                            addObject("clonediv" + counter, pos.left, pos.top);
                        }
                    });
                    $("#clonediv" + counter).addClass(itemDragged);
                    var pos = $(ui.helper).offset();

                    addObject("clonediv" + counter, pos.left, pos.top);
                }
            }
        });
        commonInitiate();
    });

    function commonInitiate() {

        $.each($('.dragCommon'), function () {

            $('#' + this.id).draggable({
                containment: 'parent',
                stop: function (ev, ui) {
                    var pos = $(ui.helper).offset();
                    addObject(this.id, pos.left, pos.top);
                    $('#' + this.id).resizable({aspectRatio: true,
                        resize: function (event, ui) {
                            addObject(this.id, pos.left, pos.top);
                        }
                    });
                }
            });



        });

    }
    function uploadTracker() {
        $('#trackerImage').click();
    }

    function upload() {
        //  $('#imageUploadForm').submit()
        $("body").addClass("loading");
        var form = document.getElementById('imageUploadForm');
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
// Add any event handlers here...
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText);
                console.log(obj);
                $("body").removeClass("loading");
                if (obj.success == '1') {
                    $('#frame').css("background-image", "url(" + obj.path + ")");
                }
            }
        };

        xhr.open('POST', 'trackerUpload', true);
        xhr.send(formData);

    }

    function addObject(objName, xpos, ypos) {
        var type = $('#' + objName).attr('type');
        var width = $('#' + objName).css('width');
        var height = $('#' + objName).css('height');
        var main_class = $('#' + objName).attr('main_class');
        
        var tracker_id = '<?php echo $tracker_id ?>';
        console.log(tracker_id);
        $.ajax({
            type: "POST",
            url: 'addUpdateObject',
            data: {type: type, width: width, height: height, xpos: xpos, ypos: ypos, main_class: main_class, tracker_id: tracker_id, object_div: objName},
            success: function (msg) {
             
            }
        });

    }
</script>
<div class="modal"><!-- Place at bottom of page --></div>
<div class="container">
    <div id="wrapper">
        <div class = "row">
            <div class = "col-md-9">

            </div>
            <div class = "col-md-3"> <button onclick ="uploadTracker()" class = "btn btn-success trackerButton">Upload Tracker</button></div>
            <form  style ="display: none" enctype="multipart/form-data" name ="imageUploadForm" id =  "imageUploadForm" method = "post" action = "trackerUpload">
                <input type="file"  id ="trackerImage" name = "trackerImage" onchange="upload()">
                <input type ="hidden" name ="tracker_id" value = "{{$tracker_id}}">
            </form>

        </div>
        </br>
        <div id="options">
            <div class="card-header">Objects</div>
            <div id="drag1" main_class ="dragged1" type ="google" class="drag dragCommon"></div> <!-- end of drag1 -->
            <div id="drag2" main_class ="dragged2" type ="facebook" class="drag dragCommon"></div> <!-- end of drag2 -->
            <div id="drag3" main_class ="dragged3" type ="audio" class="drag dragCommon"></div> <!-- end of drag3 -->
            <div id="drag4" main_class ="dragged4" type ="video" class="drag dragCommon"></div> <!-- end of drag4 -->
            <div id="drag5" main_class ="dragged5" type ="image" class="drag dragCommon"></div> <!-- end of drag5 -->
            <div id="drag6" main_class ="dragged6" type ="email" class="drag dragCommon"></div> <!-- end of drag6 -->
        </div><!-- end of options -->
        <div id="frame" <?php if (!empty($tracker)) { ?> style="background-image: url(<?php echo url($tracker); ?>); background-size: contain;;" <?php } ?>>
            <div class="card-header">Drop Here</div>
            <?php
            if (count($objects) > 0) {
                foreach ($objects as $object) {
                    ?>
                    <div id="<?php echo $object->object_div ?>" main_class="<?php echo $object->main_class ?>" type="<?php echo $object->type ?>" class="dragCommon ui-draggable  <?php echo $object->main_class ?>" style="position: absolute; left: <?php echo $object->xpos ?>px ; top: <?php echo $object->ypos ?>px; height:  <?php echo $object->height ?>; width:  <?php echo $object->width ?>"></div>
                    <?php
                }
            }
            ?>
        </div><!-- end of frame -->
    </div>

</div>

@endsection
