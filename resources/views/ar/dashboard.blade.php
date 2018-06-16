@extends('layouts.ar')

@section('content')

<script type="text/javascript">
    $(document).ready(function () {
        //Counter
        counter = 0;
        //Make element draggable
        $(".drag").draggable({
            helper: 'clone',
            containment: 'frame',

            //When first dragged
            stop: function (ev, ui) {
                var pos = $(ui.helper).offset();
                objName = "#clonediv" + counter
                $(objName).css({"left": pos.left, "top": pos.top});
                $(objName).removeClass("drag");


                //When an existiung object is dragged
                $(objName).draggable({
                    containment: 'parent',
                    stop: function (ev, ui) {
                        var pos = $(ui.helper).offset();
                        console.log($(this).attr("id"));
                        console.log(pos.left)
                        console.log(pos.top)
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
                    console.log(itemDragged)
                     $("#clonediv" + counter).css('position','absolute');
                    $("#clonediv" + counter).resizable({ aspectRatio:true });
                    $("#clonediv" + counter).addClass(itemDragged);
                     
                }
            }
        });
    });

</script>

<div class="container">
    <div id="wrapper">
      
        <div id="options">
            <div class="card-header">Objects</div>
            <div id="drag1" class="drag dragCommon"></div> <!-- end of drag1 -->
            <div id="drag2" class="drag dragCommon"></div> <!-- end of drag2 -->
            <div id="drag3" class="drag dragCommon"></div> <!-- end of drag3 -->
            <div id="drag4" class="drag dragCommon"></div> <!-- end of drag4 -->
            <div id="drag5" class="drag dragCommon"></div> <!-- end of drag5 -->
            <div id="drag6" class="drag dragCommon"></div> <!-- end of drag6 -->
        </div><!-- end of options -->
        <div id="frame">
         <div class="card-header">Drop Here</div>
            
        </div><!-- end of frame -->
    </div>
</div>
@endsection
