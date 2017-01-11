$(document).ready(function () {

    $('.calendarpost').click(function () {
        
        var driver_id  = $('#current_driver :selected').val();
        var post_id = $(this).attr('calendar-id');
        
        if ($(this).hasClass("redigera")) {
            if ($(this).hasClass("tagen")) {
                driver_id='';
                $(this).toggleClass('free-day', true);
                $(this).toggleClass('tagen', false);
                $(this).text('-----');
            } else {
                var driver_name = $('#current_driver :selected').text();
                $(this).toggleClass('tagen', true);
                $(this).toggleClass('free-day', false);
                $(this).text(driver_name);
            }
            $('#update_calendar').append('<input type= "hidden" name= "driver[]" value="' + driver_id + '"  /> ');
            $('#update_calendar').append('<input type= "hidden" name= "post_id[]" value="' + post_id + '"  /> ');
        }

    });

    $('.redigera').hover(
            function () {
                $(this).toggleClass('post-in-focus');
            },
            function () {
                $(this).toggleClass('post-in-focus');
            });
});
//    