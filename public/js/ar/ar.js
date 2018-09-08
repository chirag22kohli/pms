function initActions() {




    $(".dragged1").off("dblclick");
    $(".dragged2").off("dblclick");
    $(".dragged3").off("dblclick");
    $(".dragged4").off("dblclick");
    $(".dragged5").off("dblclick");
    $(".dragged6").off("dblclick");


    $(".dragged1").dblclick(function () {
        //  $('#fbModal').modal('show'

        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }

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
                        if (!ValidURL(name)) {
                            $.alert('Please enter a proper Url.');
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

        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
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
                        if (!ValidURL(name)) {
                            $.alert('Please enter a proper Url.');
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
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        s
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
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
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
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Image',
            content: 'url:image?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#imagefile').val();
                        if (!name) {
                            $.alert('Please select Image.');
                            return false;
                        }

                        actionUploadImage('imageUpload', ids);
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
    //mail
    $(".dragged6").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Email',
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
                        actionUploadImage('emailUpload', ids);

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




    //weblink
    $(".dragged7").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Web Link',
            content: 'url:webLink?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#webLink').val();
                        if (!name) {
                            $.alert('Please enter web link.');
                            return false;
                        }
                        console.log(ValidURL(name));
                        if (!ValidURL(name)) {
                            $.alert('Please enter a proper Url.');
                            return false;
                        }
                        actionUploadImage('webLinkUpload', ids);

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




    //Event
    $(".dragged8").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Event',
            content: 'url:event?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var title = this.$content.find('#title').val();
                        var location = this.$content.find('#description').val();
                        var description = this.$content.find('#title').val();
                        var fromdate = this.$content.find('#start_date').val();
                        var todate = this.$content.find('#end_date').val();


                        if (!title || !location || !description || !fromdate || !todate) {
                            $.alert('Please enter all the fields.');
                            return false;
                        }
                        actionUploadImage('eventUpload', ids);

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



    //Contact
    $(".dragged9").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Contact',
            content: 'url:contact?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {

                        var name = this.$content.find('#namecontact').val();
                        var email = this.$content.find('#emailcontact').val();
                        var number = this.$content.find('#number').val();
                        var address = this.$content.find('#address').val();
                        var company = this.$content.find('#company').val();


                        if (!name || !email || !number || !address || !company) {
                            $.alert('Please enter all the fields.');
                            return false;
                        }
                        actionUploadImage('contactUpload', ids);

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


    //youtube
    $(".dragged10").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Add Youtube Link',
            content: 'url:youtube?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('#youtube').val();
                        if (!name) {
                            $.alert('Please enter youtube link.');
                            return false;
                        }

                        // console.log(validateYouTubeUrl());
                        if (!validateYouTubeUrl(name)) {
                            $.alert('Please enter a valid youtube link.');
                            return false;
                        }
                        actionUploadImage('youtubeUpload', ids);

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


    //flip
    $(".dragged11").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Reverse AR Camera',
            content: 'url:flip?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {

                        actionUploadImage('flipUpload', ids);

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


    //screenShotUpload
    $(".dragged12").dblclick(function () {
        if (!checkPlanUsage().status) {
            if (checkPlanUsage().plan_type == 'size') {
                $.alert(checkPlanUsage().message);
                return false;
            }

        }
        //  $('#fbModal').modal('show');
        var ids = this.id;
        $.confirm({
            theme: 'supervan', // 'material', 'bootstrap'
            animation: 'rotate',
            title: 'Take Screen Shot',
            content: 'url:screenShot?object_id=' + this.id,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {

                        actionUploadImage('screenShotUpload', ids);

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

function updateHieghtNewObject(id, height) {
    $.ajax({
        type: "POST",
        url: 'updateHieghtNewObject',
        data: {id: id, height: height},

        success: function (msg) {
            console.log('Done');
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
                console.log(obj.newHeight);
                $j('#' + ids).css("background-image", "url(" + obj.path + ")");
                $j('#' + ids).css("height", "" + obj.newHeight + "px");
                //  $j('#' + ids).css("background-size", "cover");
                var height = obj.newHeight + "px";
                updateHieghtNewObject(ids, height);

            }
        }
    };

    xhr.open('POST', formName, true);
    xhr.send(formData);

}


function ValidURL(str) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(str);
}
function validateYouTubeUrl(url)
{
    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    return p.test(url);
}

function checkPlanUsage() {
    var ss = $.ajax({
        type: "GET",
        url: 'checkPlanUsage',
        async: false,

        success: function (msg) {
            ss = msg.status;
        }
    }).responseJSON;
    return ss;
}
;
