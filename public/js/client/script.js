$(document).ready(function () {
    /* This code is executed after the DOM has been completely loaded */

    /* Changing thedefault easing effect - will affect the slideUp/slideDown methods: */
    $.easing.def = "easeOutBounce";

    /* Binding a click event handler to the links: */
    $('li.button a').click(function (e) {

        /* Finding the drop down list that corresponds to the current section: */
        var dropDown = $(this).parent().next();

        /* Closing all other drop down sections, except the current one */
        $('.dropdown').not(dropDown).slideUp('slow');
        dropDown.slideToggle('slow');

        /* Preventing the default event (which would be to navigate the browser to the link's address) */
        e.preventDefault();
    })
    $('#tabfirst').click();
    $('#paidProjects').dataTable();

});
function renewPlan(project_info) {
    $.ajax({
        url: "renewPlan",
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('#csr').val()
        },
        data: {plan_id: project_info},
        cache: false,
        beforeSend: function (xhr) {
            //Add your image loader here
            $.alert({
                theme: 'supervan',
                title: 'Processing Payment',
                content: 'Please wait while we process your payment and set up your AR Experience.',
            });
        },
        success: function (data) {
            if (data == 'success') {
                location.reload();
            } else {
                $.alert({
                    theme: 'supervan',
                    title: 'Payment Failed',
                    content: 'There is some issue in processing your payment, Please try again.',
                });
            }
        }
    });
}
function upgradeNowPlan(id) {
    $.ajax({
        url: "upgradeNowPlan",
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('#csr').val()
        },
        data: {plan_id: id},
        cache: false,
        beforeSend: function (xhr) {
            //Add your image loader here
            $.alert({
                theme: 'supervan',
                title: 'Processing Payment',
                content: 'Please wait while we process your payment and set up your AR Experience.',
            });
        },
        success: function (data) {
            if (data == 'success') {
                location.href = 'planinfo';
            } else {
                $.alert({
                    theme: 'supervan',
                    title: 'Payment Failed',
                    content: 'There is some issue in processing your payment, Please try again.',
                });
            }
        }
    });
}


