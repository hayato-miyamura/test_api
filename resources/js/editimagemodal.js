$(function () {
    $('.item_image').on('click', function () {
        $('#edit_image_modal').modal('show');

        $tr = $(this).closest('tr');

        const $data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#item_id').val($data[0]);
    });
});