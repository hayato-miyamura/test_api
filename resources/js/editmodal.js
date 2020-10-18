$(function () {
    $('.editbtn').on('click', function() {
        $('#edit_item_modal').modal('show');

        $tr = $(this).closest('tr');

        const $data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#id').val($data[0]);
        $('#title').val($data[1]);
        $('#description').val($data[3]);
        $('#price').val($data[4].replace("円", "").replace(/,/g, ""));
    });
});