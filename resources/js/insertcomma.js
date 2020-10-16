$(function () {
    // 価格にカンマをいれる
    $('.item_price').each(function() {
        $(this).html(addFigure($(this).html()));
    });

    function addFigure(str) {
        let num = new String(str).replace(/,/g, "");
        while (num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
        return num;
    }
});