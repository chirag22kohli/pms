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

                        actionUpload('googleUpload');
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

                        actionUpload('facebookUpload');
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
    $(".dragged5").click(function () {
        //  $('#fbModal').modal('show');
        $.alert({
            title: 'Alert!',
            content: 'Simple alert!',
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
}



//individual

function open_google_image() {
    $('#get_social_google').click();
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
