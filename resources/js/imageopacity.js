$(function () {
    $('.item_image').hover(function () {
        $(this).fadeTo("500", 0.5);
    }, function () {
        $(this).fadeTo("500", 1.0);
    });
});