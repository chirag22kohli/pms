function initActions() {




    $(".dragged1").off("dblclick");
    $(".dragged2").off("dblclick");
    $(".dragged3").off("dblclick");
    $(".dragged4").off("dblclick");
    $(".dragged5").off("dblclick");
    $(".dragged6").off("dblclick");


    //Google
    $(".dragged1").dblclick(function () {
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Google Button!',
            content: 'url:google?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#google_msg').val();
                        if (!name) {
                            $.alert('Please enter message.');
                            return false;
                        }

                        actionUploadImage('googleUpload', ids);


                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });

    //Facebook
    $(".dragged2").dblclick(function () {
        //  $('#fbModal').modal('show');
        var ids = this.id;

        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Facebook Button!',
            content: 'url:facebook?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#facebook_msg').val();
                        if (!name) {
                            $.alert('Please enter message.');
                            return false;
                        }

                        actionUploadImage('facebookUpload', ids);

                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });

    //Audio
    $(".dragged3").dblclick(function () {
        //  $('#fbModal').modal('show');
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add an Audio file',
            content: 'url:audio?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#audiofile').val();
                        if (!name) {
                            $.alert('Please Select File.');
                            return false;
                        }

                        actionUpload('audioUpload');
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });

    //Video
    $(".dragged4").dblclick(function () {
        //  $('#fbModal').modal('show');
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add an Audio file',
            content: 'url:video?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#videofile').val();
                        if (!name) {
                            $.alert('Please Select File.');
                            return false;
                        }

                        actionUpload('videoUpload');
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });
    //image
    $(".dragged5").dblclick(function () {
        //  $('#fbModal').modal('show');
        $.alert({
            title: 'In Progress',
            content: 'Working on this!',
        });
    });
    //mail
    $(".dragged6").dblclick(function () {
        //  $('#fbModal').modal('show');
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add an Video file',
            content: 'url:email?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#email').val();
                        if (!name) {
                            $.alert('Please enter Email.');
                            return false;
                        }

                        actionUpload('emailUpload');
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });


    // for selection and remove

    $('.dragCommon').click(function () {
        $('.dragCommon').css('border', 'none');
        $('.dragCommon').find("span").remove();
        $('#' + this.id).css('border', '2px dotted');
        $('#' + this.id).append('<span onclick = " deleteObject(' + this.id + ')" id="close">x</span>');

        $j('#' + this.id).resizable({aspectRatio: true,
            ghost: true,
            resize: function (event, ui) {

                //  addObject(this.id, pos.left, pos.top, left_tracker, top_tracker);
            },
            stop: function (e, ui) {
                var pos = $(ui.helper).offset();
                var left_tracker = pos.left - $("#frame").position().left;
                var top_tracker = pos.top - $("#frame").position().top;
                addObject(this.id, pos.left, pos.top, left_tracker, top_tracker);
            }
        });
    });
}



//individual

function open_google_image() {
    $('#get_social_google').click();
}

function deleteObject(id) {



    $.confirm({
        theme: 'supervan', // 'material', 'bootstrap'
        animation: 'rotate',
        title: 'Delete Object?',
        content: 'Are you sure you want to delete this object? This action cannot be undone.',
        buttons: {
            confirm: function () {
                $.ajax({
                    type: "POST",
                    url: 'deleteObject',
                    data: {id: id.id},

                    success: function (msg) {
                        $("#" + id.id).remove();
                        $.alert('Object has been deleted.');
                    }
                });

            },
            cancel: function () {
                //  $.alert('Canceled!');
            }
        }
    });


}

function actionUpload(formName) {
    //  $('#imageUploadForm').submit()
    $j("body").addClass("loading");
    var form = document.getElementById(formName);
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
// Add any event handlers here...
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            // console.log(obj);
            $j("body").removeClass("loading");

            if (obj.success == '1') {
                // $j('#frame').css("background-image", "url(" + obj.path + ")");

            }
        }
    };

    xhr.open('POST', formName, true);
    xhr.send(formData);

}

function actionUploadImage(formName, ids) {
    //  $('#imageUploadForm').submit()
    $j("body").addClass("loading");
    var form = document.getElementById(formName);
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
// Add any event handlers here...
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            // console.log(obj);
            $j("body").removeClass("loading");

            if (obj.success == '1') {
                $j('#' + ids).css("background-image", "url(" + obj.path + ")");

            }
        }
    };

    xhr.open('POST', formName, true);
    xhr.send(formData);

}
